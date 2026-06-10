<?php
//src/Models/User.php
namespace src\Models;

class User {

    private $id_user;
    private $name;
    private $email;
    private $telefone;
    private $tipo;
    private $status;
    private $unique_id;

    // Construtor: ideal para preencher o objeto se a busca for bem-sucedida
    public function __construct(array $data = []) {

        if ($data) {
            $this->id_user = $data['id_user'] ?? null;
            $this->name = $data['username'] ?? null;
            $this->email = $data['email'] ?? null;
            $this->telefone = $data['telefone'] ?? null;
            $this->tipo = $data['tipo'] ?? null;
            $this->status = $data['status'] ?? null;
            $this->unique_id = $data['unique_id'] ?? null;
        }
    }

    // --- GETTERS & SETTERS (Seus métodos de acesso) ---

    public function getIdUser() {
        return $this->id_user;
    }
    public function setIdUser($id_user) { 
        $this->id_user = $id_user; return $this; 
    }
    
    public function getName() { 
        return $this->name; 
    }
    public function setName($name) { 
        $this->name = $name; return $this; 
    }
    

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
        return $this;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function getUnique()
    {
        return $this->unique_id;
    }

    public function setUnique($unique_id)
    {
        $this->unique_id = $unique_id;
        return $this;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

}