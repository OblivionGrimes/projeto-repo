<?php
namespace src\Repositories;

require_once __DIR__ . '/../Repositories/QueryRepository.php';
use PDOException;
use src\Models\Pieces\Motivo;

class PiecesRepository extends QueryRepository
{

    ################# motivo ####################

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

    ################# tipo vidro ####################

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

    ################## espessuras ####################
    public function getAllEspessuras(): array
    {
        try {
            $stmt = $this->select('espessura', '*', '', '', '', true);
            return $stmt;
        } catch (PDOException $e) {
            // Log the error message for debugging purposes
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }


    ################## Create reposição ####################
    public function createPiece(array $data)
    {
        try {
            // primeiro insert é na tabela pedidos
            $select_pedido = $this->select('pedidos', 'id_pedido', 'num_pedido = ' . $data['numero_pedido'] . ' ', '', '', false);
            $pedido_id = $select_pedido != false ? array_values($select_pedido)[0] : null;

            if ($pedido_id === null) {

                $select_cliente = $this->select('clientes', 'id_cliente', 'unique_id = ' . $data['cliente_id'] . ' ', '', '', false);
                $id_cliente = array_values($select_cliente)[0] ?? null;
                $pedido_id = $this->insert('pedidos', 'num_pedido , cliente_id', "{$data['numero_pedido']} | {$id_cliente}", true);

            }

            $select_motivo = $this->select('motivo', 'id_motivo', 'unique_id = ' . $data['motivo_id'] . ' ', '', '', false);
            (int) $id_motivo = array_values($select_motivo)[0] ?? null;

            $select_vidro = $this->select('tipo_vidro', 'id_vidro', 'unique_id = ' . $data['vidro_id'] . ' ', '', '', false);
            (int) $id_vidro = array_values($select_vidro)[0] ?? null;

            $altura_largura = explode('x', strtolower($data['altura_largura']));
            (int) $altura = $altura_largura[0];
            (int) $largura = $altura_largura[1];

            $stmt = $this->insert('peca', 'num_peca, pedido_id, motivo_id, vidro_id, espessura_id, altura_peca, largura_peca', "{$data['numero_peca']} | {$pedido_id} | {$id_motivo} | {$id_vidro} | {$data['espessura_id']} | {$altura} | {$largura}", false);

            return $pedido_id;
            
        } catch (PDOException $e) {
            // Log the error message for debugging purposes
            error_log("Database error: " . $e->getMessage());
            return $e->getMessage();
        }
    }
    
}