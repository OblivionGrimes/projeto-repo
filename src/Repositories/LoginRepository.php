<?php

namespace src\Repositories;

use src\Core\Database;
use src\Models\User;


require_once __DIR__ . '/../Core/Database.php';
use PDO;
use PDOException;

class LoginRepository extends Database{
    
    public function autenticarUsuario(string $email, string $password): ?User
    {
        try {
            $stmt = $this->mysqlConnection->prepare(
                "SELECT * FROM users WHERE email_user = ? LIMIT 1"
            );

            $stmt->execute([$email]);

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado === false) {
                return null;
            }
            if (empty($resultado['password_user']) || !password_verify($password, $resultado['password_user']) ) {
                return null;
            }

            return new User($resultado);

        } catch (PDOException $e) {
            error_log('Erro ao autenticar usuário: ' . $e->getMessage());
            return null;
        }
    }

    // Invalida a sessão atual e redireciona para a página de login
    public function logUsuario($user_id, $id_address, $user_agente, $acao): void {
        
        $stmt = $this->mysqlConnection->prepare("INSERT INTO logs_acesso (user_id, acao, ip_address, user_agent, data_log) VALUES (?, ?, ?, ?, now())");
        $stmt->execute([$user_id, $acao, $id_address, $user_agente]);

    }

    // Verifica se o usuário está logado caso contrário, redireciona para a página de login
    public function redirectIfNotLogged(): void {
        if (!isset($_SESSION['logged_user'])) {
            session_destroy();
            header("Location: ". BASE_URL ."login");
            exit();
        }
    }

    // Salva o codigo de recuperação no banco de dados
    public function saveRecoveryCode($email, $codigo){
        $stmt = $this->mysqlConnection->prepare("INSERT INTO recovery_keys (key_recover, email, create_at) values (?, ?, now())");
        $stmt->execute([$codigo, $email]);

        return $stmt->rowCount() > 0;
    }

    // Verifica se o codigo de recuperação é válido
    public function verifyRecoveryCode($codigo){
        $stmt = $this->mysqlConnection->prepare("SELECT * FROM recovery_keys WHERE key_recover = ? AND create_at >= NOW() - INTERVAL 15 MINUTE ORDER BY create_at DESC LIMIT 1");
        $stmt->execute([$codigo]);

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $stmt->rowCount() > 0;
    }


}