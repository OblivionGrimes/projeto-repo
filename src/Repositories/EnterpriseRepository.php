<?php

namespace src\Repositories;

use src\Core\Database;
use src\Models\Enterprise;
use PDO;

class EnterpriseRepository extends Database
{
    /**
     * Retorna todas as empresas existentes no sistema
     */
    public function getAllEnterprises(): array
    {
        $sql = "SELECT * FROM empresas ORDER BY nome ASC";
        $stmt = $this->mysqlConnection->prepare($sql);
        $stmt->execute();

        $empresas = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $empresas[] = new Enterprise($row);
        }

        return $empresas;
    }

    /**
     * Retorna os IDs das empresas com base em seus unique_ids
     */
    public function getIdEnterprises(array $uniqueIds): array
    {
        if (empty($uniqueIds)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($uniqueIds), '?'));

        $sql = "
            SELECT id_empresa
            FROM empresas
            WHERE unique_id IN ($placeholders)
            ORDER BY nome ASC
        ";

        $stmt = $this->mysqlConnection->prepare($sql);
        $stmt->execute(array_values($uniqueIds));

        $Idempresas = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Idempresas[] = $row['id_empresa'];
        }

        return $Idempresas;
    }


    /**
     * Retorna as empresas vinculadas a um usuário específico
     */
    public function getEnterpriseByIdUser(int $id_user): array
    {
        $sql = "SELECT e.* 
                FROM empresas e
                INNER JOIN users_x_empresa ue ON ue.empresa_id = e.id_empresa
                WHERE ue.user_id = ?";

        $stmt = $this->mysqlConnection->prepare($sql);
        $stmt->execute([$id_user]);

        $empresas = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $empresas[] = new Enterprise($row);
        }

        return $empresas;
    }

    /**
     * Retorna dados da empresa
     */
    public function getEnterpriseById(int $id_empresa): array
    {
        $sql = "SELECT 
                    nome,
                    cnpj,
                    status,
                    data_cadastro
                FROM 
                    empresas 
                WHERE 
                    id_empresa = ?";

        $stmt = $this->mysqlConnection->prepare($sql);
        $stmt->execute([$id_empresa]);

        $empresas = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $empresas[] = new Enterprise($row);
        }

        return $empresas;
    }

    public function getEnterpriseByUnique(string $unique_id): array
    {
        $sql = "SELECT 
                    nome,
                    cnpj,
                    status,
                    data_cadastro
                FROM 
                    empresas 
                WHERE 
                    unique_id = ?";

        $stmt = $this->mysqlConnection->prepare($sql);
        $stmt->execute([$unique_id]);

        $empresas = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $empresas[] = new Enterprise($row);
        }

        return $empresas;
    }

    /**
     * Atualiza os vínculos entre usuário e empresas (Talvez não seja mais utilizada)
     */
    public function updateUserEnterprises(int $userId, array $empresaIds): void
    {

        $this->mysqlConnection->beginTransaction();

        try {

            $stmtDelete = $this->mysqlConnection->prepare("
                DELETE FROM users_x_empresa
                WHERE user_id = ?
            ");
            $stmtDelete->execute([$userId]);

            $stmtInsert = $this->mysqlConnection->prepare("
                    INSERT INTO users_x_empresa (user_id, empresa_id)
                    VALUES (?, ?)");
            foreach ($empresaIds as $empresaId) {
                $stmtInsert->execute([
                    $userId,
                    (int) $empresaId
                ]);
            }

            $this->mysqlConnection->commit();

        } catch (\Throwable $e) {
            $this->mysqlConnection->rollBack();
            throw $e;
        }

    }      
    /**
     * Criar nova empresa
     */
    public function createEnterprise(array $data): ?bool
    {
        try {
            $sql = "INSERT INTO empresas (cnpj, nome, data_cadastro)
                    VALUES (?, ?, NOW())";

            $stmt = $this->mysqlConnection->prepare($sql);

            return $stmt->execute([
                $data['cnpj'],
                $data['nome']
            ]);

        } catch (\PDOException $e) {

            if ($e->getCode() === '23000') {
                return null; // CNPJ duplicado
            }

            throw $e;
        }
    }

    /**
     * Editar uma empresa
     */
    public function editEnterprise(array $data): ?bool
    {
        try {
            $sql = "update empresas set cnpj = ?, nome = ? where unique_id = ?";

            $stmt = $this->mysqlConnection->prepare($sql);

            return $stmt->execute([
                $data['cnpj'],
                $data['nome'],
                $data['unique_id']
            ]);

        } catch (\PDOException $e) {

            if ($e->getCode() === '23000') {
                return null; // CNPJ duplicado
            }

            throw $e;
        }
    }


    /**
     * desativar e ativar empresa
     */
    public function desativaEmpresa(string $unique_id, int $change): bool
    {
        $status = ($change == 1)? 'ativo' : 'inativo';
        $sql = "update empresas set status = '".$status."' WHERE unique_id = ? ";
        $stmt = $this->mysqlConnection->prepare($sql);
        return $stmt->execute([$unique_id]);
    }
}
