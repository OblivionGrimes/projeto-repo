<?php
namespace src\Repositories;

require_once __DIR__ . '/../Repositories/QueryRepository.php';
use PDOException;
use src\Models\Pieces\Motivo;

class PiecesRepository extends QueryRepository
{
    public function createMotive(string $data): bool
    {
        try {
            
            $stmt = $this->insert('motivo', 'motivo', $data);
            return $stmt;

        } catch (PDOException $e) {
            // Log the error message for debugging purposes
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function getAllMotives(): array
    {
        try {
            $stmt = $this->select('motivo', '*', '', '', '', true);
            return $stmt;
        } catch (PDOException $e) {
            // Log the error message for debugging purposes
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    public function getMotiveByUniqueId(string $unique_id): ?Motivo
    {
        try {
            $stmt = $this->select('motivo', '*', 'unique_id = ' . $unique_id . ' ', '', '', false);
            return new Motivo($stmt);
        } catch (PDOException $e) {
            // Log the error message for debugging purposes
            error_log("Database error: " . $e->getMessage());
            return null;
        }
    }

    public function getAllPiecesByMotiveId(int $motive_id): array
    {
        try {
            $stmt = $this->select('pecas', '*', 'motivo_id = ' . $motive_id, '', '', true);
            return $stmt;
        } catch (PDOException $e) {
            // Log the error message for debugging purposes
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    public function deleteMotive(string $unique_id): bool
    {
        try {
            $stmt = $this->delete('motivo', 'unique_id = ' . $unique_id . ' ');
            return $stmt;
        } catch (PDOException $e) {
            // Log the error message for debugging purposes
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function createGlass(string $nomeGlass): bool
    {
        try {
            $stmt = $this->insert('tipo_vidro', 'tipo_vidro', $nomeGlass);
            return $stmt;
        } catch (PDOException $e) {
            // Log the error message for debugging purposes
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function getAllGlass(): array
    {
        try {
            $stmt = $this->select('tipo_vidro', '*', '', '', '', true);
            return $stmt;
        } catch (PDOException $e) {
            // Log the error message for debugging purposes
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    public function getGlassByUniqueId(string $unique_id): ?array
    {
        try {
            $stmt = $this->select('tipo_vidro', '*', 'unique_id = ' . $unique_id . ' ', '', '', false);
            return $stmt;
        } catch (PDOException $e) {
            // Log the error message for debugging purposes
            error_log("Database error: " . $e->getMessage());
            return null;
        }
    }

    public function getAllPiecesByGlassId(int $glass_id): array
    {
        try {
            $stmt = $this->select('pecas', '*', 'vidro_id = ' . $glass_id, '', '', true);
            return $stmt;
        } catch (PDOException $e) {
            // Log the error message for debugging purposes
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    public function deleteGlass(string $unique_id): bool
    {
        try {
            $stmt = $this->delete('tipo_vidro', 'unique_id = ' . $unique_id . ' ');
            return $stmt;
        } catch (PDOException $e) {
            // Log the error message for debugging purposes
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    
}
