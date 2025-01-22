<?php

class Database{

    private $username = "root";
    private $password = "";
    private $hostname = "localhost";
    private $dbname = "project";
    private $connection = NULL;

    function __construct(){
       $this->connection = $this->db_connect();
    }

    function db_connect(){
        $conn = new mysqli($this->hostname,$this->username,$this->password,$this->dbname);
        if ($conn-> connect_errno) {
            return (object) array('message'=> "Connection failed: " . $conn -> connect_error);
        }else{
            return $conn;
        }
    }

  

    function getData($query=""){
        try{
            if($this->connection){
                $result = $this->connection->query($query);     //this->connection is not null If the connection exists, the function proceeds to execute the query.
                if (!$result) {
                    throw new Exception($this->connection->error);
                }
                $count = $result->num_rows;       // check the number of rows returned by the query
                if($count > 0){
                    return array("success"=> true,"message">"Data found","data"=>$result->fetch_all(MYSQLI_ASSOC));    //the retrieved data as an associative array
                }  else{
                    return array("success"=> false,"message">"No data found","data"=>array());
                } 
            }else{
                return array("success"=> false,"message">"Database connection error","data"=>array());
            }
    
        }catch(Exception $e ){
            return array("success"=> false,"message"=>$e->getMessage(),"data"=>array());
           
        }
    }


    function getRowData($query) {
        if (!empty($this->connection)) {
            $dbres = $this->connection->query($query);
            if ($dbres && $dbres->num_rows > 0) {
                return mysqli_fetch_assoc($dbres);
            } else {
                return false;
            }
        }
        return false;
    }

    function runQuery($query)
    {
        if (!empty($this->connection)) {
            $dbres = $this->connection->query($query);
            $res = $this->connection->affected_rows;
            // print_r($query);die;
            if ($res > 0) {
                return $res;
            } else {
                return false;
            }
        }
    }
}
?>