<?php

  /**
   * Classe pessoa
   */
  class Pessoa {

    var $id;
    var $primeiro_nome;
    var $ultimo_nome;
    var $email;
    var $data_hora_atual;

    function __construct()
    {
      $this->data_hora_atual = date("Y-m-d H:i:s");
    }

    function toString()
    {
      return $this->primeiro_nome . ' ' . $this->ultimo_nome . ' ' . $this->email . ' ' .$this->data_hora_atual;
    }

  }


 ?>
