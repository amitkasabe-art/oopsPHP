<?php 
    error_reporting(0);
class Database{
    private $db_host = "localhost";
    private $db_user = "root";
    private $db_pass = "";
    private $db_name = "kanshhgp_admin";
    private $conn = false;
    private $connection = false;
    private $result = array();
    private $mysqli = "";
    public function __construct()
    {
        if(!$this->conn){
            $this->mysqli = new mysqli($this->db_host , $this->db_user , $this->db_pass , $this->db_name);
            $this->conn = true;
            if($this->mysqli->connect_error){
                echo "failed";
                return false;
            }
            
        } else {
            return true;
        }
    }
    public function insert($table , $params = array())
    {
    //   database 
        if($this->tableExist($table)){
            $table_columns = implode(", " , array_keys($params));
            $table_values = implode("', '" , $params);
            $sql = "INSERT INTO $table ($table_columns) VALUES ('$table_values')";
            if($this->mysqli->query($sql)){
                array_push($this->result , $this->mysqli->insert_id);
                return true;
            } else {
                array_push($this->result , $this->mysqli->error);
                return false;
            }
        } else {
            return false;
        }
    }
    private function tableExist($table)
    {
        $sql = "SHOW TABLES FROM $this->db_name LIKE '$table'";
        $tableInDb = $this->mysqli->query($sql);
        if($tableInDb){
            if($tableInDb->num_rows == 1){
                return true;
            } else {
                return false;
                array_push($this->result,$table."Does not exist");
            }
        }
    }
    public function update($table , $params=array() , $where=null)
    {
        $args = [];
        foreach($params as $key => $value){
            $args[] = "$key = '$value'";
        }
        if($this->tableExist($table)){
            $sql = "UPDATE $table SET ".implode(',' , $args);
            if($where != null){
                $sql.=" WHERE $where";
            }
            echo $sql;
            if($this->mysqli->query($sql)){
               echo "Success";
                return true;
            } else {
                array_push($this->result , $this->mysqli->error);
            }
        }
    }
    public function delete($table , $where = null)
    {
        // Delete .. 
        if($this->tableExist($table)){
            $sql = "DELETE FROM $table";
            if($where!=null){ 
                $sql.=" WHERE $where";
            }
            if($this->mysqli->query($sql)){
                array_push($this->result, $this->mysqli->insert_id);
                return true;
            } else {
                array_push($this->result, $this->mysqli->error);
                return false;
            }
        }


    }
    public function select($table , $rows="*",$join=null , $where=null,$order=null,$limit=null)
    {
        if($this->tableExist($table)){
            $sql = "SELECT $rows FROM $table";
            if($join!=null){
                $sql .= " JOIN $join";
            }
            if($where!=null){
                $sql .= " WHERE $join";
            }
            if($order!=null){
                $sql .= " ORDER BY $order";
            }
            
            if($limit!=null){
                $sql .= " limit 0 , $limit";
            }
            $query = $this->mysqli->query($sql);
            if($query){
                $this->result=$query->fetch_all(MYSQLI_ASSOC);
                return true;
            } else {
                array_push($this->result , $this->mysqli->error);
                return false;
            }

        }else{
            return false;
        }
    }
    public function sql($sql)
    {
        $query = $this->mysqli->query($sql);
        if($query){
            $this->result=$query->fetch_all(MYSQLI_ASSOC);
            return true;
        } else {
            array_push($this->result , $this->mysqli->error);
            return false;
        }

    }
    public function GetResult()
    {
        $val = $this->result;
        $this->result = array();
        return $val;
    }
    public function __destruct(){
        if($this->conn){
            if($this->mysqli->close()){
                $this->conn = false;
            }
        } else {
            return false;
        }
    }
    
}






?>