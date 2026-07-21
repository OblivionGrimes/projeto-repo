<?php

namespace src\Models;

class Pieces {

    private string $unique_id;
    private string $motivo;
    private string $CREATE_AT;

    public function __construct(array $data = []){
        if($data){
            $this->unique_id = $data['unique_id'] ?? null;
            $this->motivo = $data['motivo'] ?? null;
            $this->CREATE_AT = $data['CREATE_AT'] ?? null;
        }
    }

    // --- GETTERS & SETTERS ---
    public function getUniqueId() {
        return $this->unique_id;
    }
    public function setUniqueId(string $unique_id) {
        $this->unique_id = $unique_id;
        return $this;
    }

    public function getMotivo() {
        return $this->motivo;
    }
    public function setMotivo(string $motivo) {
        $this->motivo = $motivo;
        return $this;
    }

    public function getCREATE_AT() {
        return $this->CREATE_AT;
    }
    public function setCREATE_AT(string $CREATE_AT) {
        $this->CREATE_AT = $CREATE_AT;
        return $this;
    }

}