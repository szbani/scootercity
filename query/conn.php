<?php
if (!defined('ACCESS_ALLOWED'))exit();

class dataBase{
  private $connection = null;
  public function __construct($dbhost= 'localhost',$dbname='scootercity',$dbuser='root',$dbpass='',$charset='utf8')
  { 
    try{
      $this->connection = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
      $this->connection->set_charset($charset);
      if(mysqli_connect_errno()){
        throw new Exception('Sikertelen kapcsolódás az adatbázishoz!');
      }
    }catch(Exception $e){
      throw new Exception($e->getMessage());
    }
  }
  
  private function executeStatement( $query = '',$params=[]){
    try{
      $stmnt = $this->connection->prepare($query);
      if($stmnt === false){
        throw new Exception("nem lehet végrehajtani a parancsot: " .$query);
      }
      if($params){
        call_user_func_array(array($stmnt, 'bind_param'),$params);
      }
      $stmnt->execute();
      return $stmnt;
    }catch(Exception $e){
      throw new Exception($e->getMessage());
    }

  }

  public function Select($query = '',$params = []){
    try{
      $stmnt = $this->executeStatement($query,$params);
      $result = $stmnt->get_result()->fetch_all(MYSQLI_ASSOC);
      $stmnt->close();
      
      return $result;
    }catch(Exception $e){
      throw new Exception($e->getMessage());
    }
    return false;
  }

}


?>