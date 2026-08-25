<?php

namespace src\Repositories;

require_once __DIR__ . '/../Repositories/QueryRepository.php';
use PDOException;

class UserRepository extends QueryRepository
{

    // Cadastra um novo funcionario ao sistema
    public function createMarker(string $nome_conferente, string $turno_conferente, string $tipo_conferente): bool
    {
        try {
            $stmt = $this->insert('conferente', 'nome_conferente, turno_conferente, tipo_conferente', "{$nome_conferente}|{$turno_conferente}|{$tipo_conferente}");
            return $stmt;
        } catch (PDOException $e) {
            // Log the error message for debugging purposes
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function getAllMarkers(): array
    {
        try {
            $stmt = $this->select('conferente', '*', '', '', '', true);
            return $stmt;
        } catch (PDOException $e) {
            // Log the error message for debugging purposes
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    public function changeStatusMarker(string $unique_id, string $status): bool
    {
        $stmt = $this->update("conferente", "status_conferente = ".trim($status)." ", "unique_id = ".$unique_id." ");
        return $stmt;
    }

    public function getMarkerByUniqueId(string $unique_id): array|object|null
    {
        try {
            $stmt = $this->select('conferente', '*', 'unique_id = ' . $unique_id . ' ', '', '', false);
            return $stmt;
        } catch (PDOException $e) {
            // Log the error message for debugging purposes
            error_log("Database error: " . $e->getMessage());
            return null;
        }
    }

    public function getAllPiecesByMarkerId(int $marker_id): array
    {
        try {
            $stmt = $this->select('pecas', '*', 'conferente_id = ' . $marker_id, '', '', true);
            return $stmt;
        } catch (PDOException $e) {
            // Log the error message for debugging purposes
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    public function deleteMarker(string $unique_id): bool
    {
        try {
            $stmt = $this->delete('conferente', 'unique_id = ' . $unique_id . ' ');
            return $stmt;
        } catch (PDOException $e) {
            // Log the error message for debugging purposes
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    // buscar todos os usuários
    public function buscarTodosUsuarios(): array 
    {
        $resultados = $this->mysqlConnection->query("SELECT * FROM usuarios");
        
        $usuarios = [];
        while ($row = $resultados->fetch()) {
            $usuarios[] = $row;
        }
        return $usuarios;
    }

    // Desativa e Ativa usuario
    public function desativaUser(string $unique_id, int $change): bool
    {
        $status = ($change == 1)? 'ativo' : 'inativo';
        $sql = "update usuarios set status = '".$status."' WHERE unique_id = ? ";
        $stmt = $this->mysqlConnection->prepare($sql);
        return $stmt->execute([$unique_id]);
    }

    // Atualiza a senha do usuário
    public function updatePassword(string $unique_id, string $newPassword): bool
    {
        $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

        $sql = "UPDATE usuarios SET password_hash = ? WHERE unique_id = ?";

        $stmt = $this->mysqlConnection->prepare($sql);
        return $stmt->execute([$passwordHash, $unique_id]);

    }

    
}