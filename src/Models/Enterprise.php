<?php

namespace src\Models;

class Enterprise {

    private $id_empresa;
    private $nome;
    private $cnpj;
    private $unique_id;
    private $status;
    private $data_cadastro;

    public function __construct(array $data = []) {
        if ($data) {
            $this->id_empresa = $data['id_empresa'] ?? null;
            $this->nome = $data['nome'] ?? null;
            $this->cnpj = $data['cnpj'] ?? null;
            $this->unique_id = $data['unique_id'] ?? null;
            $this->status = $data['status'] ?? null;
            $this->data_cadastro = $data['data_cadastro'] ?? null;
        }
    }

    // --- GETTERS & SETTERS ---

    public function getIdEmpresa() {
        return $this->id_empresa;
    }

    public function setIdEmpresa($id_empresa) { 
        $this->id_empresa = $id_empresa; return $this; 
    }
    
    public function getNameEmpresa() { 
        return $this->nome; 
    }
    public function setNameEmpresa($nome) { 
        $this->nome = $nome; return $this; 
    }

    public function getCnpj() {
        return $this->cnpj;
    }

    public function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
        return $this;
    }

    public function getUniqueId() {
        return $this->unique_id;
    }

    public function setUniqueId($unique_id) {
        $this->unique_id = $unique_id;
        return $this;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function getDataCadastro() {
        return $this->data_cadastro;
    }

    public function setDataCadastro($data_cadastro) {
        $this->data_cadastro = $data_cadastro;
        return $this;
    }

}


