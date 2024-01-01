<?php
require("../model/productos.php");
require("../model/users.php");
require("../database/conexion.php");
class GenericTable {
    private $table_created = array();
    private $connect;
    public function __construct(){
        $this->connect = new conexion();
    }
    public function CreateTableIfNotExist($className) {
        $tableName = strtolower(get_class($className));

        $command = sprintf(
            "CREATE TABLE IF NOT EXISTS %s (%s);",
            $tableName,
            implode(', ', array_map(function ($name, $type) {
                return "$name $type";
            }, array_keys($className->columns), $className->columns))
        );
        $this->table_created[] = $tableName;
        $this->ExecuteCommand($command);
        return $command; // O ejecuta la consulta
    }
    public function RollBackTableNotDeclared(){
        $sqlshow = $this->GetCommandSql("show tables");
         foreach ($sqlshow as $table){
             if(!in_array($table,$this->table_created)){
                 $CommandDelete = "delete from " . $table[0];
                 $this->ExecuteCommand($CommandDelete);
             }
        }
 }
   
    public function GetDataTable($tableName){
        $command = "select * from ".$tableName;
        $sql = $this->GetCommandSql($command);
        return $sql;
    }
    
    public function GetColumnTable($tableName){
        $command = "describe ".$tableName;
        $sql = $this->GetCommandSql($command);
        return $sql;
    }
    public function GetCommandSql($command){
        return $this->connect->conectar()->query($command)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function GetTableCreated(){
        return $this->table_created;
    }
    public function InsertIntoTable($tableName,$data){
        $columns = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));
        // Construir la consulta SQL
        $command = "INSERT INTO $tableName ($columns) VALUES ($values)";
        $sql = $this->connect->conectar()->prepare($command);
        //$this->ExecuteCommand($command);
        //return $command;
        return $sql->execute($data);
    }
    public function DeleteToTable($tableName,$id){
        $command = "delete from $tableName where id = $id";
        $sql = $this->ExecuteCommand($command);
        return $command;
    }
    function ExecuteCommand($command){
        $this->connect->conectar()->query($command)->execute();
    }
    public function __destruct()
    {
        //$this->RollBackTableNotDeclared();
    }


}
$genericTable = new GenericTable();
$genericTable->CreateTableIfNotExist(new Productos);
$genericTable->CreateTableIfNotExist(new Usuarios);
//$genericTable->CreateTableIfNotExist(new Comida())
?>
    