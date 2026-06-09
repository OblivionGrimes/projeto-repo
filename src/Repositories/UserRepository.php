<?php

namespace src\Repositories;

use PDO;
use src\Core\Database;
use src\Models\User;

require_once __DIR__ . '/../Core/Database.php';

class UserRepository extends Database
{
    // criação do user
    public function createCommonUser(array $data, int|array|null $empresaIds, int $tipo): int
    {
        // --- Tipo de usuário ---
        $tipoUsuario = match ($tipo) {
            1 => 'comum',
            2 => 'admin',
            3 => 'master',
            default => throw new \InvalidArgumentException('Tipo de usuário inválido')
        };

        // --- Empresas vinculadas (pode ser tanto um array quanto um inteiro) ---
        if ($empresaIds === null) {
            $empresaIds = [];
        } elseif (is_int($empresaIds)) {
            $empresaIds = [$empresaIds];
        } elseif (is_array($empresaIds)) {
            $empresaIds = array_values(array_filter($empresaIds, fn ($id) => !empty($id)));
        } else {
            throw new \InvalidArgumentException('Formato inválido de empresaIds');
        }

        // Validação: Usuários que não são master devem ter ao menos uma empresa vinculada
        if ($tipoUsuario !== 'master' && empty($empresaIds)) {
            throw new \InvalidArgumentException('Selecione ao menos uma empresa.');
        }

        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);

        $this->mysqlConnection->beginTransaction();

        try {

            $stmt = $this->mysqlConnection->prepare(
                "SELECT COUNT(*) FROM usuarios WHERE email = ?"
            );
            $stmt->execute([$data['email']]);

            // mudar aqui para aparecer um alerta só
            if ((int) $stmt->fetchColumn() > 0) {
                throw new \Exception("O email '".$data['email']."' já está em uso.");
            }

            // Inserção do usuário
            $stmt = $this->mysqlConnection->prepare("
                INSERT INTO usuarios (
                    username,
                    email,
                    password_hash,
                    tipo,
                    status,
                    data_cadastro,
                    telefone
                ) VALUES (?, ?, ?, ?, 'ativo', NOW(), ?)
            ");

            $stmt->execute([
                $data['username'],
                $data['email'],
                $passwordHash,
                $tipoUsuario,
                $data['telefone'] ?? null
            ]);

            $userId = (int) $this->mysqlConnection->lastInsertId();

            // Vinculação do usuário às empresas
            if (!empty($empresaIds)) {
                $stmtVinculo = $this->mysqlConnection->prepare("
                    INSERT IGNORE INTO users_x_empresa (user_id, empresa_id)
                    VALUES (?, ?)
                ");

                foreach ($empresaIds as $empresaId) {
                    $stmtVinculo->execute([
                        $userId,
                        (int) $empresaId
                    ]);
                }
            }

            $this->mysqlConnection->commit();

            return $userId;

        } catch (\Throwable $e) {
            $this->mysqlConnection->rollBack();
            throw $e;
        }
    }

    // Edita dados do usuario
    public function updateCommonUser(array $data, int|array|null $empresaIds, int $tipo): int
    {
        // --- Tipo de usuário ---
        $tipoUsuario = match ($tipo) {
            1 => 'comum',
            2 => 'admin',
            3 => 'master',
            default => throw new \InvalidArgumentException('Tipo de usuário inválido')
        };

        // --- Empresas vinculadas ---
        if ($empresaIds === null) {
            $empresaIds = [];
        } elseif (is_int($empresaIds)) {
            $empresaIds = [$empresaIds];
        } elseif (is_array($empresaIds)) {
            $empresaIds = array_values(array_filter($empresaIds, fn ($id) => !empty($id)));
        } else {
            throw new \InvalidArgumentException('Formato inválido de empresaIds');
        }

        if ($tipoUsuario !== 'master' && empty($empresaIds)) {
            throw new \InvalidArgumentException('Selecione ao menos uma empresa.');
        }

        $this->mysqlConnection->beginTransaction();

        try {

            // 🔹 Montagem dinâmica do UPDATE
            $sql = "
                UPDATE usuarios SET
                    username = ?,
                    email = ?,
                    tipo = ?,
                    telefone = ?
            ";

            $params = [
                $data['username'],
                $data['email'],
                $tipoUsuario,
                $data['telefone'] ?? null,
            ];

            // 🔐 Atualiza senha SOMENTE se foi enviada
            if (!empty($data['password'])) {
                $sql .= ", password_hash = ?";
                $params[] = password_hash($data['password'], PASSWORD_DEFAULT);
            }

            $sql .= " WHERE id_user = ?";
            $params[] = $data['id_user'];

            $stmt = $this->mysqlConnection->prepare($sql);
            $stmt->execute($params);

            // 🔹 Atualiza vínculo de empresas
            $stmtDelete = $this->mysqlConnection->prepare("
                DELETE FROM users_x_empresa
                WHERE user_id = ?
            ");
            $stmtDelete->execute([$data['id_user']]);

            $stmtInsert = $this->mysqlConnection->prepare("
                INSERT INTO users_x_empresa (user_id, empresa_id)
                VALUES (?, ?)
            ");

            foreach ($empresaIds as $empresaId) {
                $stmtInsert->execute([
                    $data['id_user'],
                    (int) $empresaId
                ]);
            }

            $this->mysqlConnection->commit();

            return $data['id_user'];

        } catch (\Throwable $e) {
            $this->mysqlConnection->rollBack();
            throw $e;
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

    // buscar usuário por unique_id
    public function buscaUserPorUniqueId(string $unique_id): ?User
    {
        $stmt = $this->mysqlConnection->prepare("
            SELECT * 
            FROM usuarios 
            WHERE unique_id = ?
            LIMIT 1
        ");

        $stmt->execute([$unique_id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new User($row);
    }

    // buscar usuário por email
    public function buscaUserPorEmail(string $email): ?User
    {
        $stmt = $this->mysqlConnection->prepare("
            SELECT unique_id
            FROM usuarios 
            WHERE email = ?
            LIMIT 1
        ");

        $stmt->execute([$email]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new User($row);
    }

    // Retorna usuários vinculados a uma empresa
    public function getUsersByEmpresa(int $empresa_id): array
    {
        $sql = "
            SELECT u.*
            FROM usuarios u
            INNER JOIN users_x_empresa ue ON ue.user_id = u.id_user
            WHERE ue.empresa_id = ?
            ORDER BY u.username
        ";

        $stmt = $this->mysqlConnection->prepare($sql);
        $stmt->execute([$empresa_id]);

        $users = [];
        while ($row = $stmt->fetch()) {
            $users[] = new User($row);
        }

        return $users;
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