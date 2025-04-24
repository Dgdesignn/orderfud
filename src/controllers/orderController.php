<?php
require_once "../models/orderModels.php";
require_once "../config/database.php";
   
class OrderController{
    private $connection;
    private $model;
    private $NotificationsModel;

    public function __construct(){
        $this->connection = new Database();
        $this->model = new OrderModel($this->connection->getConnection());
    }
    public function totalPedidos(){
      return $this->model->totalPedidos();
    }
  
}
    
?>