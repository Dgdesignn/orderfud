<?php
class ClassModel{
    private $connection;

    public function __construct($connection){
        $this->connection=$connection;

    }

    public function addcionarAluno($idTurma, $sigla, $classe){
        try {
            $query=$this->connection->prepare("INSERT INTO turma(idTurma, sigla, classe) VALUES (:idTurma, :sigla, :classe)");
            $query->bindParam(':idTurma', $idTurma);
            $query->bindParam(':sigla', $sigla);
            $query->bindParam(':classe', $classe);
            return $query ->execute();
        } catch (PDOExcepection $e) {
            echo "erro". $e->getMessage();
        }

    }
    public function buscarAluno(){
       try {
        $sql = ("SELECT * FROM turma");
        $result = $this->connection->query($sql);
        $result-> execute();
        return $result;
       } catch (PDOException $e) {
        echo "erro".$e->getMessage();
       }
    }
    
    
}
?>