<?php
// database credentials
class Database {
    private $host = DB_HOST;
    private $username = DB_USER;
    private $password = DB_PASS;
    private $database = DB_NAME;
    private $connection;

    // Constructor to create database connection
    public function __construct() {
        try {
            $this->connection = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException) {
            echo "Connection Failed! " ;die;
        }
    }
    // Destructor to close connection
    public function __destruct() {
        $this->connection = null;
    }

    // Method to insert data into a table
    public function insert($table, $data) {
        $table = Sanitizer::sanitize($table);
        $data = Sanitizer::sanitize($data);
        // insert('table_name' , ['key1'=>'value1',...])
        $keys = implode(',', array_keys($data));
        $values = implode(',', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO $table ($keys) VALUES ($values)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array_values($data));
        return $stmt->rowCount();
    }

    // get last id
    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }

    // Method to update data in a table
    public function update($table, $data, $condition) {
        $table = Sanitizer::sanitize($table);

        $set = [];
        foreach($data as $key => $value) {
            $set[] = "$key = ?";
        }
        $set = implode(',', $set);
        $sql = "UPDATE $table SET $set WHERE $condition";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array_values($data));
        return $stmt->rowCount();
    }

    // Method to delete data from a table
    public function delete($table, $condition) {
        $table = Sanitizer::sanitize($table);

        $sql = "DELETE FROM $table WHERE $condition";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();
    }

    // Method to select data from a table
    public function select($table, $condition, $columns = "*", $order_by = "id" , $order= "ASC") {
        $table = Sanitizer::sanitize($table);

        $sql = "SELECT $columns FROM $table WHERE $condition ORDER BY $order_by $order";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Method to select one record from a table
    public function select_once($table, $condition, $columns = "*"){
        $sql = "SELECT $columns FROM $table WHERE $condition";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Method to select all data from a table
    public function all($table, $columns = "*" , $order_by = "id" , $order= "ASC") {
        $sql = "SELECT $columns FROM $table ORDER BY $order_by $order";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to get list of data
    public function get_list($table, $condition, $column = "id"){
        $list = $this->select($table , $condition , $column);
        if(empty($list)){
            return false;
        }else{
            $column_value = [];
            foreach($list as $l){
                array_push($column_value,$l[$column]);
            }
            return $column_value;
        }
    }
}

?>