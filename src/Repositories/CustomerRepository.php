<?php

namespace src\Repositories;
use Exception;
use src\Models\Customer;

require_once __DIR__ . '/../Repositories/QueryRepository.php';
use PDO;
use PDOException;

require_once __DIR__ . '/../../Config/Config.php';
use Config\Config;
class CustomerRepository extends QueryRepository
{

        /**
     * Criar novo cliente
     */
    public function createCliente(array $data)
    {
        $config = new Config();

        try {

            $contato = empty($data['contato_cliente']) ? null : $config->sanitize($data['contato_cliente']);
            $cnpj = empty($data['cnpj']) ? null : $config->sanitize($data['cnpj']);

            $stmt = $this->insert('clientes', 'numero_cliente, nome_cliente, contato_cliente, cnpj_cliente', "{$data['numero_cliente']}| {$data['nome_cliente']}| {$contato}| {$cnpj}");

            return $stmt;

        } catch (PDOException $e) {

            if ($e->getCode() === '23000') {
                return null; // algo duplicado
            }

            throw $e;
        }
    }

    /**
     * Editar uma empresa
     */
    public function editCustomer(array $data)
    {
        $config = new Config();

        try {

            $stmt = $this->update("clientes", "numero_cliente = {$data['numero_cliente']}, nome_cliente = {$data['nome_cliente']}, contato_cliente = {$data['contato_cliente']}, cnpj_cliente = {$data['cnpj_cliente']}, status_cliente = {$data['status_cliente']}, gm_cliente = {$data['gm_cliente']}", "unique_id = ".$data['unique_id']." ");

            return $stmt;

        } catch (PDOException $e) {

            if ($e->getCode() === '23000') {
                return null; // algo duplicado
            }

            throw $e;
        }
    }


    /**
     * desativar e ativar empresa
     */
    public function changeStatus(string $unique_id, int $change): bool
    {
        $status = ($change == 1)? 'ativo' : 'inativo';
        $sql = "update empresas set status = '".$status."' WHERE unique_id = ? ";
        $stmt = $this->mysqlConnection->prepare($sql);
        return $stmt->execute([$unique_id]);
    }

    /**
     * Retorna todas as empresas existentes no sistema
     */
    public function getAllCustomers()
    {
        $sql = "SELECT * FROM clientes ORDER BY nome_cliente ASC";
        $stmt = $this->select_livre($sql);

        $empresas = [];

        foreach ($stmt as $row) {
            $empresas[] = new Customer($row);
        }

        return $empresas;
    }

    /**
     * Retorna os IDs das empresas com base em seus unique_ids
     */
    public function getIdCustomer(string $uniqueId)//: ? Customer
    {
        try{
            $stmt = $this->select("clientes", "*", "unique_id = ".$uniqueId." ");

            $return = new Customer($stmt);

            return $return;
        }
        catch(PDOException $e){
            throw $e;
        }

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
            $empresas[] = new Customer($row);
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
            $empresas[] = new Customer($row);
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
            $empresas[] = new Customer($row);
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

}
