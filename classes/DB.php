<?php

namespace classes;

class DB
{
    private $db_host = DB_HOST;
    private $db_user = DB_USER;
    private $db_pass = DB_PASS;
    private $db_name = DB_NAME;

    protected $pdo = null;
    protected $table = null;

    /**
     * Set connect to Database.
     */
    public function __construct()
    {
        if ( is_null($this->pdo) ) {
            try {
                $this->pdo = new \PDO(
                    'mysql:host=' . $this->db_host . ';dbname=' . $this->db_name,
                    $this->db_user,
                    $this->db_pass,
                    [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]
                );
            } catch (\PDOException $e) {
                die('Error to connect with Database');
            }
        }
    }

    /**
     * Close connection with Database.
     */
    public function closeConnection()
    {
        $this->pdo = null;
    }

    /**
     * Select data with Database.
     *
     * @param array $data
     * @param int $fetchType
     * @param int $limit
     *
     * @return array
     */
    public function getData($data, $fetchType = \PDO::FETCH_CLASS, $limit = 1)
    {
        $keys = array_keys($data);
        $fields = implode(',', $keys);
        $placeholder = mb_substr( str_repeat('?,', count($keys) ), 0, -1 );

        $sql = 'SELECT * FROM ' . $this->table
            . ' WHERE ' . $fields . ' = ' . $placeholder
            . ' LIMIT ' . $limit;

        $dbh = $this->pdo->prepare($sql);
        $dbh->execute( array_values($data) );
        return $dbh->fetchAll($fetchType);
    }

    /**
     * Get data by id.
     *
     * @param int $id
     *
     * @return object
     */
    public function getByID($id)
    {
        $sql = 'SELECT * FROM ' . $this->table
            . ' WHERE id = :id';
        $dbh = $this->pdo->prepare($sql);
        $dbh->bindValue(':id', $id, \PDO::PARAM_INT);
        $dbh->execute();
        return $dbh->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * Update by id.
     *
     * @param array $dataOne
     * @param int $id
     *
     * @return bool
     */
    public function updateByID($dataOne, $id)
    {
        $key = array_keys($dataOne)[0];
        $value = array_values($dataOne)[0];

        $sql = 'UPDATE ' . $this->table . ' '
            . 'SET ' . $key . '=? WHERE id=?';
        $dbh = $this->pdo->prepare($sql);
        $dbh->bindValue(1, $value);
        $dbh->bindValue(2, $id, \PDO::PARAM_INT);
        return $dbh->execute();
    }

    /**
     * Insert data in Database.
     *
     * @param array $data
     *
     * @return bool
     */
    public function insert($data)
    {
        $keys = array_keys($data);
        $fields = implode(',', $keys);
        $placeholder = mb_substr( str_repeat('?,', count($keys) ), 0, -1);

        $sql = 'INSERT INTO ' . $this->table . '(' . $fields . ')'
            . ' VALUES (' . $placeholder . ')';
        return $this->pdo->prepare($sql)->execute( array_values($data) );
    }

    /**
     * Insert data in Database.
     *
     * @param array $data
     * @param array $param
     *
     * @return bool
     */
    public function update($data, $param)
    {
        $keysData = array_keys($data);
        $fieldsData = implode('=?,', $keysData) . '=?';

        $keysParam = array_keys($param);
        $fieldsParam = implode('=?,', $keysParam) . '=?';

        $arr = array_merge( array_values($data), array_values($param) );

        $sql = 'UPDATE ' . $this->table . ' '
            . 'SET ' . $fieldsData . ' WHERE ' . $fieldsParam;
        return $this->pdo->prepare($sql)->execute($arr);
    }

    /**
     * Get random value with Table Database.
     *
     * @return int
     */
    public function getCountRecords()
    {
        $sql = 'SELECT COUNT(1) FROM ' . $this->table;
        $dbh = $this->pdo->prepare($sql);
        $dbh->execute();
        return $dbh->fetchColumn();
    }

    /**
     * Get single data with Database.
     *
     * @return object
     */
    public function getRandomSingleData()
    {
        $number = rand( 1, $this->getCountRecords() );
        return $this->getData(['id' => $number])[0];
    }

    /**
     * Get Multiply Data.
     *
     * @param array $ids
     *
     * @return array
     */
    public function getMultiplyDataIDs($ids)
    {
        $fields = 'id=?' . str_repeat(' OR id=?', count($ids) - 1);

        $sql = 'SELECT * FROM ' . $this->table
            . ' WHERE ' . $fields;
        $dbh = $this->pdo->prepare($sql);

        $i = 1;
        foreach ($ids as $id) {
            $dbh->bindValue($i++, $id, \PDO::PARAM_INT);
        }

        $dbh->execute();
        return $dbh->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Get random count data.
     *
     * @param int $count
     *
     * @return array
     */
    public function getRandomCountData($count)
    {
        $sql = 'SELECT * FROM ' . $this->table
            . ' ORDER BY RAND() '
            . ' LIMIT :count';
        $dbh = $this->pdo->prepare($sql);
        $dbh->bindValue(':count', (int)$count, \PDO::PARAM_INT);
        $dbh->execute();
        return $dbh->fetchAll(\PDO::FETCH_CLASS);
    }

    /**
     * Get unique values from DB.
     * CUSTOM. TEMPORARY!
     *
     * @return array
     */
    public function getUniquePlaylist()
    {
        $sql = 'SELECT DISTINCT playlist'
            . ' FROM ' . $this->table;
        $dbh = $this->pdo->prepare($sql);
        $dbh->execute();
        return $dbh->fetchAll(\PDO::FETCH_OBJ);
    }
}
