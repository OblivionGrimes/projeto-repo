<?php
namespace src\Repositories;

require_once __DIR__ . '/../Repositories/QueryRepository.php';
use PDOException;

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
    
}
