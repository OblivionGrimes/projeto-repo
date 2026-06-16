<?php

namespace src\Repositories;

//use src\Core\Database;
use src\Models\User;


require_once __DIR__ . '/../Repositories/QueryRepository.php';
use PDO;
use PDOException;

require_once __DIR__ . '/../../Config/Config.php';
use Config\Config;


class LoginRepository extends QueryRepository{

    
    public function autenticarUsuario(string $email, string $password): ?User
    {
        $config = new Config();

        try {

            $email = $config->sanitize($email);

            $resultado = $this->select('usuarios', '*', "email = {$email}", '', '1');

            if ($resultado === false) {
                return null;
            }
            if (empty($resultado['password_hash']) || !password_verify($password, $resultado['password_hash']) ) {
                return null;
            }

            return new User($resultado);

        } catch (PDOException $e) {
            error_log('Erro ao autenticar usuário: ' . $e->getMessage());
            return null;
        }
    }

    // Invalida a sessão atual e redireciona para a página de login
    public function logUsuario(int $user_id, string $id_address, string $user_agente, string $acao) {

        try {
            $stmt = $this->insert('logs_acesso', 'user_id, acao, ip_address, user_agent', "{$user_id}| {$acao}| {$id_address}| {$user_agente}");
            return $stmt;
        }
        catch (PDOException $e) {
            error_log('Erro ao registrar log de acesso: ' . $e->getMessage());
        }
        
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
    public function saveRecoveryCode(string $email, int $codigo): bool{

        try{

            $stmt = $this->insert('recovery_keys', 'key_recover, email', "{$codigo}| {$email}");
            return $stmt;

        }catch (PDOexception $e){
            error_log('Erro ao salvar o codigo de recuperação: ' . $e->getMessage());
        }
    }

    // Verifica se o codigo de recuperação é válido
    public function verifyRecoveryCode(int $codigo){
        $stmt = $this->mysqlConnection->prepare("SELECT * FROM recovery_keys WHERE key_recover = ? AND create_at >= NOW() - INTERVAL 15 MINUTE ORDER BY create_at DESC LIMIT 1");
        $stmt->execute([$codigo]);

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $stmt->rowCount() > 0;
    }


}