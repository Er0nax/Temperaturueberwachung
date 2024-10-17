<?php

namespace src\components;

use PDO;
use PDOException;
use PDOStatement;
use src\Config;
use src\helpers\ResultHelper;

/**
 * Entry Component to receive results from the db.
 * @author Tim Zapfe
 * @copyright Tim Zapfe
 * @date 15.10.2024
 */
class Entry extends BaseComponent
{
    private ?string $tables = null;
    private ?string $columns = null;
    private array $where = [];
    private ?int $limit = null;
    private ?int $offset = null;
    private ?string $order = null;
    private ?string $type = null;
    public ?string $queryDump = null;
    private bool $distinct = false;
    private bool $asJson = false;
    private bool $reversed = false;
    private PDO $con;

    /**
     * constructor
     * @author Tim Zapfe
     */
    public function __construct(PDO $connection = null)
    {
        if (!empty($connection)) {
            $this->con = $connection;
        } else {
            $this->con = constant('Database')->con;
        }

        // reset
        $this->distinct = false;
    }

    /**
     * find single entry
     * @param bool $convertToBooleans
     * @return bool|string|array
     * @author Tim Zapfe
     */
    public function one(bool $convertToBooleans = true): bool|string|array
    {
        // get the result
        try {
            $this->type = null;
            $result = $this->execute();
        } catch (PDOException $e) {
            // nothing ...
        }

        // check if the result is empty or false
        if (empty($result)) {
            return $this->getAsJsonOrNormal([]);
        }

        // return the result
        $return = $result->fetch(PDO::FETCH_ASSOC);

        if (is_array($return)) {
            // convert to booleans?
            if ($convertToBooleans) {
                $return = $this->convertBooleans($return);
            }

            return $this->getAsJsonOrNormal($return);
        }

        return $this->getAsJsonOrNormal([]);
    }

    /**
     * returns bool whether an entry exists or not
     * @return string|bool
     * @author Tim Zapfe
     */
    public function exists(): string|bool
    {
        try {
            $this->type = null;
            $stmt = $this->execute();

            if ($stmt) {
                $exists = $stmt->fetchColumn();
            } else {
                $exists = false;
            }

            if ($exists) {
                return $this->getAsJsonOrNormal(true);
            } else {
                return $this->getAsJsonOrNormal(false);
            }

        } catch (PDOException $e) {
            return $this->getAsJsonOrNormal(false);
        }
    }

    /**
     * returns int how many rows where found
     * @return bool|string|int
     * @author Tim Zapfe
     */
    public function count(): bool|string|int
    {
        try {
            $this->type = 'COUNT';
            $stmt = $this->execute();
            $int = $stmt->fetchColumn();

            if (is_numeric($int)) {
                return $this->getAsJsonOrNormal($int);
            }

            return $this->getAsJsonOrNormal(0);

        } catch (PDOException $e) {
            return $this->getAsJsonOrNormal(0);
        }
    }

    /**
     * returns the sum
     * @return int|bool|string
     * @author Tim Zapfe
     */
    public function sum(): int|bool|string
    {
        try {
            $this->type = 'SUM';
            $stmt = $this->execute();

            $int = $stmt->fetchColumn();

            if (is_numeric($int)) {
                return $this->getAsJsonOrNormal($int);
            }

            return $this->getAsJsonOrNormal(0);
        } catch (PDOException $e) {
            return $this->getAsJsonOrNormal(0);
        }
    }

    /**
     * returns the int
     * @return int|bool|string
     * @author Tim Zapfe
     */
    public function avg(): int|bool|string
    {
        try {
            $this->type = 'AVG';
            $stmt = $this->execute();
            $int = $stmt->fetchColumn();

            if (is_numeric($int)) {
                return $this->getAsJsonOrNormal($int);
            }

            return $this->getAsJsonOrNormal(0);
        } catch (PDOException $e) {
            return $this->getAsJsonOrNormal(0);
        }
    }

    /**
     * returns the max
     * @return int|string|bool
     * @author Tim Zapfe
     */
    public function max(): int|string|bool
    {
        try {
            $this->type = 'MAX';
            $stmt = $this->execute();
            $int = $stmt->fetchColumn();

            if (is_numeric($int)) {
                return $this->getAsJsonOrNormal($int);
            }

            return $this->getAsJsonOrNormal(0);
        } catch (PDOException $e) {
            return $this->getAsJsonOrNormal(0);
        }
    }

    /**
     * returns the min
     * @return int|bool|string
     * @author Tim Zapfe
     */
    public function min(): int|bool|string
    {
        try {
            $this->type = 'MIN';
            $stmt = $this->execute();
            $int = $stmt->fetchColumn();

            if (is_numeric($int)) {
                return $this->getAsJsonOrNormal($int);
            }

            return $this->getAsJsonOrNormal(0);
        } catch (PDOException $e) {
            return $this->getAsJsonOrNormal(0);
        }
    }

    /**
     * find multiple entries
     * @param bool $convertBooleans
     * @return array|bool|string
     * @author Tim Zapfe
     */
    public function all(bool $convertBooleans = true): array|bool|string
    {
        // get the result
        try {
            $this->type = 'ALL';
            $result = $this->execute();
        } catch (PDOException $e) {
            // nothing ...
        }

        // check if the result is empty or false
        if (empty($result)) {
            return $this->getAsJsonOrNormal([]);
        }

        // return the result
        $response = $result->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($response)) {

            if ($this->reversed) {
                $response = array_reverse($response);
            }

            if ($convertBooleans) {
                $response = $this->convertBooleans($response);
            }

            return $this->getAsJsonOrNormal($response);
        }

        return $this->getAsJsonOrNormal([]);
    }


    /**
     * converts variables to booleans
     * @param array $data
     * @return array
     * @author Tim Zapfe
     */
    private function convertBooleans(array $data): array
    {
        foreach ($data as $key => &$item) {
            if (is_array($item)) {
                array_walk_recursive($item, function (&$value, $key) {
                    if ($value === 'true' || $value === 'false') {
                        $value = $value === 'true';
                    }
                });

                continue;
            }

            // convert to bool
            if ($item === 'true' || $item === 'false') {
                $data[$key] = $item === 'true';
            }
        }

        return $data;
    }

    /**
     * creates the tables query string
     * possible inputs: \n
     * ['users', ['roles', 'users.roleID', 'roles.id'], ['colors', 'roles.colorID', 'colors.id']]
     * 'users JOIN roles ON users.roleID = roles.id JOIN colors ON roles.colorID = colors.id'
     * @param $tables
     * @return Entry
     * @author Tim Zapfe
     */
    public function tables($tables): static
    {
        $tablesString = '';

        // check if the table is defined
        if (!empty($tables)) {

            // check if tables are in array form
            if (is_array($tables)) {

                $tablesString = $tables[0];
                $counter = 0;

                // loop through tables
                foreach ($tables as $table) {

                    // Skip first loop
                    if ($counter++ == 0) {
                        continue;
                    }

                    $tablesString = $tablesString . (!empty($table[3]) ? ' ' . $table[3] : '') . ' JOIN ' . $table[0] . ' ON ' . $table[1] . ' = ' . $table[2];
                }

            } else {
                $tablesString = $tables;
            }
        }

        // add tables
        $this->tables = $tablesString;

        return $this;
    }

    /**
     * creates the columns query string
     * possible inputs:
     * ['users' => ['username', 'description'], 'roles' => ['name', 'description']]
     * 'users.username, users.description, roles.name, roles.description'
     * @return $this
     * @author Tim Zapfe
     */
    public function columns($columns): static
    {
        // set query string
        $columnsString = '';

        // check if colmuns are defined
        if (!empty($columns)) {

            // check if is array
            if (is_array($columns)) {
                // is first column in query?
                $isFirstLine = false;

                // loop through array
                foreach ($columns as $table => $tableColumns) {

                    // set current table
                    $currentTable = $table;

                    // loop through columns
                    if (!empty($tableColumns) && is_array($tableColumns)) {

                        // loop through all columns in table
                        foreach ($tableColumns as $tableColumn) {

                            // check if its first column
                            if (!$isFirstLine) {
                                // without ,
                                $columnsString = $columnsString . $currentTable . '.' . $tableColumn;
                            } else {
                                // with ,
                                $columnsString = $columnsString . ', ' . $currentTable . '.' . $tableColumn;
                            }

                            // set first line to true as we got one loop
                            $isFirstLine = true;
                        }
                    }
                }

            } else {
                $columnsString = $columns;
            }
        }

        // add columns
        $this->columns = $columnsString;

        return $this;
    }

    /**
     * creates the where query string
     * possible inputs:
     * ['users' => [['username', 'Eronax'], ['deleted', 'false', '!=']], 'roles' => [['id', 'anothertable.id', '=', true]]]
     * users.username = 'Eronax' AND users.deleted != 'false' AND roles.id = anothertable.id
     * @return $this
     * @author Tim Zapfe
     */
    public function where($where, $operator = 'AND'): static
    {
        // create query string
        $whereString = '';

        // check if columns are defined
        if (!empty($where)) {

            // check if array
            if (is_array($where)) {

                $isFirstLine = false;

                // loop through all where's
                foreach ($where as $table => $conditions) {

                    // check if $conditions are set and array
                    if (!empty($conditions) && is_array($conditions)) {
                        foreach ($conditions as $condition) {
                            $column = $condition[0];
                            $is = (is_bool($condition[1]) ? $this->convertToString($condition[1]) : $condition[1]);
                            $customEqual = $condition[2] ?? '=';
                            $isCustomEqual = $condition[3] ?? false;
                            $addTablePrefix = $condition[4] ?? true;

                            if (!$isCustomEqual) {
                                $is = ($customEqual == 'LIKE') ? "'%" . $is . "%'" : "'" . $is . "'";
                            }
                            $singleString = ($addTablePrefix ? $table . '.' : '') . $column . ' ' . $customEqual . ' ' . $is;

                            if (!$isFirstLine) {
                                $whereString = $singleString;
                            } else {
                                $whereString = $whereString . ' ' . $operator . ' ' . $singleString;
                            }

                            $isFirstLine = true;
                        }
                    }
                }

            } else {
                $whereString = $where;
            }
        }

        $whereString = '(' . $whereString . ')';

        // add columns
        $this->where[0] = $whereString;

        return $this;
    }

    /**
     * @param $where
     * @param string $operator
     * @return $this
     * @author Tim Zapfe
     */
    public function addWhere($where, string $operator = 'AND'): static
    {
        // first where given? no => use it instead
        if (empty($this->where[0])) {
            $this->where[0] = $this->where($where, $operator);

            return $this;
        }

        // create query string
        $whereString = '';

        // check if columns are defined
        if (!empty($where)) {

            // check if array
            if (is_array($where)) {

                $isFirstLine = true;

                // loop through all where's
                foreach ($where as $table => $conditions) {

                    // check if $conditions are set and array
                    if (!empty($conditions) && is_array($conditions)) {
                        foreach ($conditions as $condition) {
                            $column = $condition[0];
                            $is = (is_bool($condition[1]) ? $this->convertToString($condition[1]) : $condition[1]);
                            $customEqual = $condition[2] ?? '=';
                            $isCustomEqual = $condition[3] ?? false;

                            if (!$isCustomEqual) {
                                $is = ($customEqual == 'LIKE') ? "'%" . $is . "%'" : "'" . $is . "'";
                            }
                            $singleString = $table . '.' . $column . ' ' . $customEqual . ' ' . $is;

                            if ($isFirstLine) {
                                $whereString = $singleString;
                            } else {
                                $whereString = $whereString . ' AND ' . $singleString;
                            }

                            $isFirstLine = false;
                        }
                    }
                }

            } else {
                $whereString = $where;
            }
        }

        $whereString = '(' . $whereString . ')';

        // add columns
        $key = count($this->where) + 1;
        $this->where[$key]['string'] = $whereString;
        $this->where[$key]['operator'] = $operator;

        return $this;
    }

    /**
     * @param mixed $variable
     * @return mixed|string
     * @author Tim Zapfe
     */
    private function convertToString(mixed $variable): mixed
    {
        if (is_bool($variable)) {
            if ($variable) {
                return 'true';
            } else {
                return 'false';
            }
        }

        // todo convert others to string...
        return $variable;
    }

    /**
     * @param $table
     * @return bool
     * @author Tim Zapfe
     */
    public function checkIfTablesContainsSpecificTable($table): bool
    {
        return str_contains($this->tables, $table);
    }

    /**
     * sets a limit for the query
     * @return $this
     * @author Tim Zapfe
     */
    public function limit($limit): static
    {
        // check if limit is set and is a number
        if (!empty($limit) && is_numeric($limit)) {
            $this->limit = $limit;
        }

        return $this;
    }

    /**
     * sets a new offset
     * @param $offset
     * @return $this
     * @author Tim Zapfe
     */
    public function offset($offset): static
    {
        // check if limit is set and is a number
        if (!empty($offset) && is_numeric($offset)) {
            $this->offset = $offset;
        } else {
            $this->offset = 0;
        }

        return $this;
    }

    /**
     * @param string|null $order
     * @return $this
     * @author Tim Zapfe
     */
    public function order(string $order = null): static
    {
        // check if limit is set and is a number
        if (!empty($order)) {
            $this->order = $order;
        }

        return $this;
    }

    /**
     * builds the query string
     * @author Tim Zapfe
     */
    private function buildQuery(): ?string
    {
        // set query strings
        $columns = $this->columns;
        $tables = $this->tables;
        $where = $this->where;
        $type = $this->type;
        $query = null;

        // check if all are given
        if (!empty($columns) && !empty($tables)) {

            // is specific type given?
            $type = match ($type) {
                'COUNT' => 'COUNT',
                'SUM' => 'SUM',
                'AVG' => 'AVG',
                'MAX' => 'MAX',
                'MIN' => 'MIN',
                default => null,
            };

            // type still given?
            if (!empty($type)) {
                $query = $type . '(' . $columns . ') FROM ' . $tables;
            } else {
                $query = $columns . ' FROM ' . $tables;
            }

            if ($this->distinct) {
                $query = 'SELECT DISTINCT ' . $query;
            } else {
                $query = 'SELECT ' . $query;
            }
        }

        // add where
        if (!empty($where[0])) {
            $query = $query . ' WHERE ' . $where[0];
        }

        // add another where's
        foreach ($where as $key => $value) {
            if ($key == 0) {
                continue;
            }

            $query = $query . ' ' . $value['operator'] . ' ' . $value['string'];
        }


        // add order
        if (!empty($this->order)) {
            $query = $query . ' ORDER BY ' . $this->order;
        }

        // add limit
        if (!empty($this->limit) && is_numeric($this->limit)) {
            $query = $query . ' LIMIT ' . $this->limit;
        }

        // add offset
        if (!empty($this->offset) && is_numeric($this->offset)) {
            $query = $query . ' OFFSET ' . $this->offset;
        }

        $this->queryDump = $query;
        return $query;
    }

    /**
     * execute the PDO statement
     * @return bool|PDOStatement|null
     * @author Tim Zapfe
     */
    private function execute(): bool|PDOStatement|null
    {
        try {
            // get the query
            $query = $this->buildQuery();

            if (!empty($query)) {

                // prepare statement
                $stmt = $this->con->prepare($query);

                // execute
                $stmt->execute();

                // return statement
                return $stmt;
            }

            return null;
        } catch (PDOException $e) {
            // nothing
            return null;
        }
    }

    /**
     * @param bool $die
     * @return Entry
     * @author Tim Zapfe
     */
    public function dumpQuery(bool $die = true): static
    {
        if (Config::getConfig('debugMode', false)) {
            try {
                $query = $this->buildQuery();

                echo '<pre style="background-color: #fff; border: 3px solid #ddd; margin: 10px; padding: 5px;">';
                var_dump($query);
                echo '</pre>';
                if ($die) {
                    die();
                }

            } catch (\Exception $e) {
                exit('Could not build query: ' . $e->getMessage());
            }
        }

        return $this;
    }

    /**
     * Insers new row into DB. Returns false on error and ID on success.
     * @param string $table
     * @param array $keysAndValues
     * @param bool $checkForExisting
     * @param bool $dump
     * @return bool|int
     * @author Tim Zapfe
     */
    public function insert(string $table, array $keysAndValues, bool $checkForExisting = true, bool $dump = false): bool|int
    {
        // table given?
        if (empty($table)) {
            if ($dump) {
                ResultHelper::render([
                    'message' => 'Unknown table while inserting into db.'
                ], 500, ['translate' => true]);
            }
            return false;
        }

        // values given?
        if (empty($keysAndValues)) {
            if ($dump) {
                ResultHelper::render([
                    'message' => 'Unknown keys and values while inserting into db.'
                ], 500, ['translate' => true]);
            }
            return false;
        }

        $unallowedKeys = ['updated_at', 'created_at'];

        // filter keys and values
        foreach ($keysAndValues as $key => $value) {
            // does key do not have a valid name?
            if (is_numeric($key)) {
                if ($dump) {
                    ResultHelper::render([
                        'message' => 'key "' . $key . '" with value "' . $value . '" is not valid!'
                    ], 500);
                }
                return false;
            }

            // value is null? yes => unset
            if (!isset($value)) {
                unset($keysAndValues[$key]);
            }

            if (in_array($key, $unallowedKeys)) {
                unset($keysAndValues[$key]);
            }
        }

        // check if row already exists?
        if ($checkForExisting) {
            // entry already exists?
            $entry = new Entry($this->con);

            // build where part for query
            $where = [];
            foreach ($keysAndValues as $key => $value) {
                $where[$table][] = [$key, $value];
            }

            // build query
            $existingRowQuery = $entry->columns('id')->tables($table)->where($where);
            $exists = $existingRowQuery->exists();

            // entry found?
            if ($exists) {
                if ($dump) {
                    ResultHelper::render([
                        'message' => 'row already exists while inserting into db.'
                    ], 500, ['translate' => true]);
                }

                $IdOfExistingRow = $existingRowQuery->one();
                if (is_numeric($IdOfExistingRow['id'])) {
                    return $IdOfExistingRow['id'];
                }

                return false;
            }
        }

        // build keys and values strings
        $keys = [];
        $values = [];
        foreach ($keysAndValues as $key => $value) {
            // add them
            $keys[] = $key;
            $values[] = ':' . $key;
        }

        try {
            // set the PDO error mode to exception
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Vorbereiten der SQL-Anweisung
            $sql = 'INSERT INTO ' . $table . ' (' . implode(', ', $keys) . ') VALUES (' . implode(',', $values) . ')';

            // Vorbereiten der Anweisung
            $stmt = $this->con->prepare($sql);

            // Werte binden
            foreach ($keysAndValues as $key => $_value) {
                $param = ':' . $key;
                $stmt->bindValue($param, $_value);
            }

            // Ausführen der Anweisung
            $stmt->execute();

            return $this->con->lastInsertId();
        } catch (PDOException $e) {
            if ($dump) {
                ResultHelper::render([
                    'message' => $e->getMessage()
                ], 500);
            }
            return false;
        }
    }

    /**
     * @param string $table
     * @param array $keysAndValues
     * @param array $whereConditions
     * @param bool $dump
     * @return bool
     * @author Tim Zapfe
     */
    public function update(string $table, array $keysAndValues, array $whereConditions, bool $dump = false): bool
    {
        // table given?
        if (empty($table)) {
            if ($dump) {
                ResultHelper::render([
                    'message' => 'Unknown table while updating in db.'
                ], 500, ['translate' => true]);
            }
            return false;
        }

        // values given?
        if (empty($keysAndValues)) {
            if ($dump) {
                ResultHelper::render([
                    'message' => 'Unknown keys and values while updating in db.'
                ], 500, ['translate' => true]);
            }
            return false;
        }

        // where conditions given?
        if (empty($whereConditions)) {
            if ($dump) {
                ResultHelper::render([
                    'message' => 'Unknown keys and values while updating in db.'
                ], 500, ['translate' => true]);
            }
            return false;
        }

        try {
            // set the PDO error mode to exception
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // build keys and values strings
            $setValues = [];
            foreach ($keysAndValues as $key => $value) {
                // any part not given?
                if (!isset($key) || !isset($value)) {
                    if ($dump) {
                        ResultHelper::render([
                            'message' => 'Unknown key or value while updating in db.'
                        ], 500, ['translate' => true]);
                    }
                    return false;
                }
                // add em
                $setValues[] = "$key = :$key";
            }

            // build where clause
            $whereClause = [];
            foreach ($whereConditions as $key => $value) {
                // any part not given?
                if (!isset($key) || !isset($value)) {
                    if ($dump) {
                        ResultHelper::render([
                            'message' => 'Unknown key or value for where clause while updating in db.'
                        ], 500, ['translate' => true]);
                    }
                    return false;
                }
                // add em
                $whereClause[] = "$key = :where_$key";
            }

            // prepare SQL statement
            $sql = 'UPDATE ' . $table . ' SET ' . implode(', ', $setValues) . ' WHERE ' . implode(' AND ', $whereClause);

            // prepare statement
            $stmt = $this->con->prepare($sql);

            // bind values to parameters
            foreach ($keysAndValues as $key => $value) {
                $param = ':' . $key;

                // check if boolean
                if (is_bool($value)) {
                    $value = $value ? 'true' : 'false';
                }

                $stmt->bindValue($param, $value);
            }

            // bind values for where conditions
            foreach ($whereConditions as $key => $value) {
                $param = ':where_' . $key;

                // check if boolean
                if (is_bool($value)) {
                    $value = $value ? 'true' : 'false';
                }

                $stmt->bindValue($param, $value);
            }

            // execute statement
            $stmt->execute();

            return true;

        } catch (PDOException $e) {
            if ($dump) {
                ResultHelper::render([
                    'message' => $e->getMessage()
                ], 500);
            }
            return false;
        }
    }

    /**
     * resets all current set values
     * @return $this
     * @author Tim Zapfe
     */
    public function reset(): static
    {
        $this->tables = null;
        $this->columns = null;
        $this->where = [];
        $this->limit = null;
        $this->offset = null;
        $this->order = null;
        $this->type = null;
        $this->queryDump = null;
        $this->distinct = false;
        $this->asJson = false;
        $this->reversed = false;

        return $this;
    }

    /**
     * @param bool $asJson
     * @return $this
     * @author Tim Zapfe
     */
    public function asJson(bool $asJson = true): static
    {
        $this->asJson = $asJson;

        return $this;
    }

    /**
     * @param mixed $content
     * @return false|string
     * @author Tim Zapfe
     */
    private function getAsJsonOrNormal(mixed $content): mixed
    {
        if ($this->asJson) {
            $jsonFormatted = json_encode($content, JSON_UNESCAPED_UNICODE);

            if (is_string($jsonFormatted)) {
                return $jsonFormatted;
            }
        }

        return $content;
    }

    /**
     * whether an array should be given reversed
     * @param bool $reversed
     * @return Entry
     * @author Tim Zapfe
     */
    public function reversed(bool $reversed = true): static
    {
        $this->reversed = $reversed;

        return $this;
    }

    /**
     * Whether the query should contain the distinct attribute or not
     * @param bool $distinct
     * @return $this
     * @author Tim Zapfe
     */
    public function distinct(bool $distinct = true): static
    {
        $this->distinct = $distinct;

        return $this;
    }
}