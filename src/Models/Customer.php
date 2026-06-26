<?php

namespace src\Models;
class Customer {

    private $id_cliente;
    private $nome_cliente;
    private $cnpj_cliente;
    private $unique_id;
    private $status_cliente;
    private $gm_cliente;
    private $numero_cliente;
    private $contato_cliente;

    public function __construct(array $data = []) {
        if ($data) {
            $this->id_cliente = $data['id_cliente'] ?? null;
            $this->nome_cliente = $data['nome_cliente'] ?? null;
            $this->cnpj_cliente = $data['cnpj_cliente'] ?? null;
            $this->unique_id = $data['unique_id'] ?? null;
            $this->status_cliente = $data['status_cliente'] ?? null;
            $this->gm_cliente = $data['gm_cliente'] ?? null;
            $this->numero_cliente = $data['numero_cliente'] ?? null;
            $this->contato_cliente = $data['contato_cliente'] ?? null;
        }
    }

    // --- GETTERS & SETTERS ---

    public function getIdCliente() {
        return $this->id_cliente;
    }

    public function setIdCliente($id_cliente) { 
        $this->id_cliente = $id_cliente; return $this; 
    }
    
    public function getNameCliente() { 
        return $this->nome_cliente; 
    }

    public function setNameCliente($nome_cliente) { 
        $this->nome_cliente = $nome_cliente; return $this; 
    }

    public function getCnpj() {
        return $this->cnpj_cliente;
    }

    public function setCnpj($cnpj_cliente) {
        $this->cnpj_cliente = $cnpj_cliente;
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
        return $this->status_cliente;
    }

    public function setStatus($status_cliente) {
        $this->status_cliente = $status_cliente;
        return $this;
    }

    public function getGmCliente() {
        return $this->gm_cliente;
    }

    public function setGmCliente($gm_cliente) {
        $this->gm_cliente = $gm_cliente;
        return $this;
    }

    public function getNumeroCliente() {
        return $this->numero_cliente;
    }

    public function setNumeroCliente($numero_cliente) {
        $this->numero_cliente = $numero_cliente;
        return $this;
    }

    public function getContatoCliente() {
        return $this->contato_cliente;
    }

    public function setContatoCliente($contato_cliente) {
        $this->contato_cliente = $contato_cliente;
        return $this;
    }

}


