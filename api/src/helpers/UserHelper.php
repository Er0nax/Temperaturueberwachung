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
    public static function getApiToken(string|int $userId): string
    {
        $entry = new Entry();

        // check if token with user id exists
        $entry->columns(['api_tokens' => ['*']])
            ->tables('api_tokens')
            ->where(['api_tokens' => [
                ['active', true],
                ['user_id', $userId]
            ]]);

        $tokenExists = $entry->exists();

        // does exist?
        if ($tokenExists) {
            $info = $entry->one();

            // update uses
            $entry->update('api_tokens',
                ['uses' => $info['uses'] + 1],
                ['user_id' => $userId, 'token' => $info['token']]
            );

            return $info['token'];
        }

        $token = self::generateApiToken();
        $ip = $_SERVER['REMOTE_ADDR'];

        // create new token
        $entry->insert('api_tokens', [
            'user_id' => $userId,
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
        return strtolower(preg_replace('/[^a-zA-Z0-9_]/', '', $username));
    }

    /**
     * Returns boolean whether a username is valid or not.
     * @param string $username
     * @return true
     * @author Tim Zapfe
     * @copyright Tim Zapfe
     * @date 22.10.2024
     */
    public static function isValidUsername(string $username): bool
    {
        // Define the disallowed characters
        $disallowedCharacters = "'/!\"\\#*+~;,:§$%&{([)]=}?°^´`<>|";

        // Define an array of disallowed words
        $disallowedWords = ['Nigga', 'Nigger', 'Niger', 'Niga', 'root', 'admin', 'administrator'];

        // Check for disallowed characters
        if (strpbrk($username, $disallowedCharacters) !== false) {
            return false; // Return false if any disallowed character is found
        }

        // Check for disallowed words (case-insensitive)
        foreach ($disallowedWords as $word) {
            if (stripos($username, $word) !== false) {
                return false; // Return false if any disallowed word is found
            }
        }

        return true; // Return true if the username is valid
    }

    /**
     * Returns boolean whether a username exists or not.
     * @param string $username
     * @return bool
     * @author Tim Zapfe
     * @copyright Tim Zapfe
     * @date 23.10.2024
     */
    public static function checkIfUsernameExists(string $username): bool
    {
        $entry = new Entry();
        $entry->columns(['users' => ['username']])
            ->tables('users')
            ->where(['users' => [['username', $username]]]);

        return $entry->exists();
    }

    /**
     * Returns the Entry for a user.
     * @return Entry
     * @author Tim Zapfe
     * @copyright Tim Zapfe
     * @date 23.10.2024
     */
    public static function getUserQuery(): Entry
    {
        $entry = new Entry();

        return $entry->columns(['users' => ['id', 'username', 'snowflake', 'phone', 'active', 'last_seen', 'created_at', 'updated_at'],
            'user_settings' => ['language', 'imperial_system', 'darkmode'],
            'images' => ["src AS 'avatar'"],
            'roles' => ["name AS 'role_name'", "color AS 'role_color'"]
        ])->tables(['users',
            ['user_settings', 'users.id', 'user_settings.user_id', 'LEFT'],
            ['images', 'users.avatar_id', 'images.id', 'LEFT'],
            ['roles', 'users.role_id', 'roles.id', 'LEFT']
        ]);
    }
}