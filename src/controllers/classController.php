<?php

   require_once "../models/classModels.php";
   require_once "../config/database.php";

class ClassController{
    private $connection;
    private $model;

    public function __construct(){
        $this->connection = new Database();
        $this->model = new ClassModel($this->connection->getConnection());

    } 
    public function addCionarAluno($idTurma, $sigla, $classe){
        return $this->model->addCionarAluno($idTurma, $sigla, $classe);

    }
    public function buscarAluno(){
        return $this->model->buscarAluno();
    }
    
}
?>