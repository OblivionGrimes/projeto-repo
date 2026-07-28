<?php

namespace src\Models\Pieces;

class Motivo {

    private string $id_motivo;
    private string $unique_id;
    private string $motivo;
    private string $CREATE_AT;

    public function __construct(array $data = []){
        if($data){
            $this->id_motivo = $data['id_motivo'] ?? null;
            $this->unique_id = $data['unique_id'] ?? null;
            $this->motivo = $data['motivo'] ?? null;
            $this->CREATE_AT = $data['CREATE_AT'] ?? null;
        }
    }

    // --- GETTERS & SETTERS ---
    public function getIdMotivo() {
        return $this->id_motivo;
    }
    public function setIdMotivo(string $id_motivo) {
        $this->id_motivo = $id_motivo;
        return $this;
    }

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