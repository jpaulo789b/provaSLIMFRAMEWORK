<?php
// Chama a classe Pessoa
// require_once('../model/Pessoa.php');
/**
* Classe de funções
*/
class Functions{
  var $pessoa;
  var $conn;
  function __construct(){

    try {
      // Realiza a conexão
      $username = 'root';
      $password = '123456';
      $this->conn = new PDO('mysql:host=localhost;dbname=dbprova', $username, $password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->conn -> exec("set names utf8");
    } catch(PDOException $e) {
      echo 'ERROR: ' . $e->getMessage();
    }


  }

  // metodo que salva uma nova pessoa ou atualiza uma pessoa existente
  function savePessoa($pessoa){
    try {
      if($pessoa->id == null){
        // Query de inserção
        $stmt = $this->conn->prepare('INSERT INTO PROVA(primeiro_nome, ultimo_nome, email, data_hora_atual) VALUES (:primeiro_nome,:ultimo_nome,:email,:data_hora_atual)');
      }else{
        //Query de update
        $stmt = $this->conn->prepare('UPDATE PROVA SET primeiro_nome=:primeiro_nome,ultimo_nome=:ultimo_nome,email=:email,data_hora_atual=:data_hora_atual WHERE id =:id');
        $stmt->bindParam(':id',$pessoa->id);

      };
      $stmt->bindParam(':primeiro_nome',$pessoa->primeiro_nome);
      $stmt->bindParam(':ultimo_nome',$pessoa->ultimo_nome);
      $stmt->bindParam(':email',$pessoa->email);
      $stmt->bindParam(':data_hora_atual',$pessoa->data_hora_atual);
      $stmt->execute();
      $pessoa->salvo = "SALVO COM SUCESSO";
      return json_encode($pessoa);
    } catch (PDOException $e) {
      echo 'ERROR: ' . $e->getMessage();
    }
  }


  // metodo que remove uma pessoa
  function removePessoa($pessoa){
    try {
      // $query = $conn->query('DELETE FROM PROVA WHERE id =:id');
      $stmt = $this->conn->prepare('DELETE FROM PROVA WHERE id =:id');
      $stmt->bindParam(':id', $pessoa->id, PDO::PARAM_INT);
      $stmt->execute();
      $pessoa->status = "Pessoa de código $pessoa->id foi excluida do banco.";
      return json_encode($pessoa);
    } catch (PDOException $e) {
      echo 'ERROR: ' . $e->getMessage();
    }
  }

  // Acha uma pessoa, se não for informado parametro de busca, todos as pessoas são Listadas;
  function findPessoa($pessoa){
    try {
      if($pessoa->id == null){
        // Query de Seleção para todas Pessoas
        $query = $this->conn->prepare('SELECT * FROM PROVA');
      }else{
        // Query de Seleção de uma pessoa especifica pelo id
        $query = $this->conn->prepare('SELECT * FROM PROVA WHERE id =:id');
        $query->bindParam(':id',$pessoa->id);
      }
      $query->execute();
      // Diz que resultado retorna um objeto da Classe Pessoa
      $query->setFetchMode(PDO::FETCH_CLASS, 'Pessoa');
      $pessoas = array();
      while($pessoa = $query->fetch()) {
        array_push($pessoas, $pessoa);
      }
      return json_encode($pessoas);
    } catch (PDOException $e) {
      echo 'ERROR: ' . $e->getMessage();
    }

  }

}
//
?>
