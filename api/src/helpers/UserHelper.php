<?php

namespace src\helpers;

use src\components\Entry;
use src\helpers\BaseHelper;

/**
 * Helper Class for the User
 */
class UserHelper extends BaseHelper
{
    /**
     * Returns a new random Api Token
     * @author Tim Zapfe
     */
    public static function generateApiToken(): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = [];

        for ($i = 0; $i < 20; $i++) {
            $randomIndex = mt_rand(0, $charactersLength - 1);
            $randomString[] = $characters[$randomIndex];
        }

        return implode('', $randomString);
    }

    /**
     * Returns the API token for a user
     */
    public static function getApiToken(string|int $userID): string
    {
        $entry = new Entry();

        // check if token with user id exists
        $entry->columns(['api_tokens' => ['*']])
            ->tables('api_tokens')
            ->where(['api_tokens' => [
                ['active', true],
                ['userID', $userID]
            ]]);

        $tokenExists = $entry->exists();

        // does exist?
        if ($tokenExists) {
            $info = $entry->one();

            // update uses
            $entry->update('api_tokens',
                ['uses' => $info['uses'] + 1],
                ['userID' => $userID, 'token' => $info['token']]
            );

            return $info['token'];
        }

        $token = self::generateApiToken();
        $ip = $_SERVER['REMOTE_ADDR'];

        // create new token
        $entry->insert('api_tokens', [
            'userID' => $userID,
            'ip' => $ip,
            'token' => $token
        ], false);

        return $token;
    }

    /**
     * Returns a string which can only contain letters, numbers and underscores
     * @param string $username
     * @return array|string|string[]|null
     */
    public static function generateSnowflake(string $username): array|string|null
    {
        // Use a regular expression to allow only letters, numbers, and underscores
        return preg_replace('/[^a-zA-Z0-9_]/', '', $username);
    }
}