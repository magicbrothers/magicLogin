<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/link/config.php";

class DB {

    public $conn;

    function getConnection(){

        $this->conn = new mysqli(Config::$dbhost, Config::$dbuser, Config::$dbpassword, Config::$db);

        return $this->conn;
    }

    function select($cols, $table, $where = '', $order = '') {
        $sql = "SELECT $cols FROM $table";
        if($where != '') {
            $sql .= " WHERE $where";
        }
        if($order != '') {
            $sql .= " ORDER BY $order";
        }

        return $this->conn->query($sql);
    }

    function create($name, $cols) {
        $sql = "CREATE TABLE IF NOT EXISTS $name ( $cols )";

        return $this->conn->query($sql);
    }

    function insert($table, $cols, $values) {
        $sql = "INSERT INTO $table ( $cols ) VALUES ( $values )";

        return $this->conn->query($sql);
    }

    function update($table, $col, $value, $where) {
        $sql = "UPDATE $table SET $col='$value' WHERE $where";

        return $this->conn->query($sql);
    }

    function delete($table, $col, $value) {
        $sql = "DELETE FROM $table WHERE $col=$value";
        $this->conn->query($sql);
    }

}