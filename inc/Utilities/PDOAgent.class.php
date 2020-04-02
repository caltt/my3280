<?php

class PDOAgent
{
    // for pdo
    private $_host = DB_HOST;
    private $_user = DB_USER;
    private $_pass = DB_PASS;
    private $_dbname = DB_NAME;

    // db handle
    private $_dbh;
    private $_pstmt;

    private $_className;

    public function __construct(string $className)
    {
        // for result fetch
        $this->_className = $className;

        // for pdo connection
        $dsn = "mysql:host=" . $this->_host . ';dbname=' . $this->_dbname;
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];

        // connect
        try {
            $this->_dbh = new PDO($dsn, $this->_user, $this->_pass, $options);
        } catch (PDOException $pe) {
            echo $pe->getMessage();
        }
    }

    public function query(string $query)
    {
        $this->_pstmt = $this->_dbh->prepare($query);
    }

    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                // order matters, int and then bool
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
                    break;
            }
        }
        // actual binding
        $this->_pstmt->bindValue($param, $value, $type);
    }

    public function execute()
    {
        $this->_pstmt->execute();
    }

    public function resultSet()
    {
        // return specified class
        return $this->_pstmt->fetchAll(PDO::FETCH_CLASS, $this->_className);
    }

    public function singleResult()
    {
        $this->_pstmt->setFetchMode(PDO::FETCH_CLASS, $this->_className);
        $this->_pstmt->fetch(PDO::FETCH_CLASS, $this->_className);
    }

    public function lastInsertedId()
    {
        return $this->_dbh->lastInsertId();
    }

    public function rowCount()
    {
        return $this->_pstmt->rowCount();
    }
}
