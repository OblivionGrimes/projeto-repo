<?php
namespace src\Repositories;

use src\Core\Database;
use PDO;

class PermissionRepository extends Database
{

    // Verifica se o usuário é admin ou master
    public function isAdmin() {
        return isset($_SESSION['logged_user']) && ($_SESSION['logged_user']->getTipo() === 'admin' || $_SESSION['logged_user']->getTipo() === 'master');
    }

    // Verifica se o usuário é master
    public function isMaster() {
        return isset($_SESSION['logged_user']) && $_SESSION['logged_user']->getTipo() === 'master';
    }

    // Verifica se o usuário tem permissão para ver BI Frames
    public function PodeVerBiFrames($usuario_id) {
        // 1. Admin/master sempre pode
        if ($this->isAdmin()) {
            return true;
        }
        
        // 2. Verifica a permissão específica 'pode_gerenciar_bi_frames'
        $stmt = $this->mysqlConnection->prepare("SELECT pode_gerenciar_bi_frames FROM permissoes WHERE user_id = ? AND pode_gerenciar_bi_frames = 1");

        if (!$stmt) {
            error_log("Erro SQL ao checar permissão de BI Frames: "  /*$this->mysqlConnection->errorInfo()*/);
            die(); 
        }
        
        $stmt->execute([$usuario_id]);
        $row_count = $stmt->rowCount();

        return $row_count > 0;
    }

    public function PodeGerenciarPermissao($usuario_id) {
        // 1. Admin/master sempre pode
        if ($this->isAdmin()) {
            return true;
        }
        
        // 2. Verifica a permissão específica 'podec_gerenciar_permissao'
        $stmt = $this->mysqlConnection->prepare("SELECT pode_gerenciar_permissao FROM permissoes WHERE user_id = ? AND pode_gerenciar_permissao = 1");

        if (!$stmt) {
            error_log("Erro SQL ao checar permissão de Gerenciar permissões: " /*$this->mysqlConnection->errorInfo()*/);
            die(); 
        }
        
        $stmt->execute([$usuario_id]);
        $row_count = $stmt->rowCount();

        return $row_count > 0;
    }

    public function PodeVerUsuarios($usuario_id) {
        // 1. Admin/master sempre pode
        if ($this->isAdmin()) {
            return true;
        }
        
        // 2. Verifica a permissão específica 'pode_gerenciar_usuarios'
        $stmt = $this->mysqlConnection->prepare("SELECT pode_gerenciar_usuarios FROM permissoes WHERE user_id = ? AND pode_gerenciar_usuarios = 1");

        if (!$stmt) {
            error_log("Erro SQL ao checar permissão de BI Frames: "  /*$this->mysqlConnection->errorInfo()*/);
            die(); 
        }
        
        $stmt->execute([$usuario_id]);
        $row_count = $stmt->rowCount();

        return $row_count > 0;
    }

    // Busca as permissões gerais de um usuário
    public function getGeneralPermissions(int $userId): array
    {
        $sql = "
            SELECT 
                pode_gerenciar_permissao,
                pode_gerenciar_usuarios,
                pode_gerenciar_bi_frames
            FROM 
                permissoes
            WHERE 
                user_id = ?
            LIMIT 1
        ";
        
        $stmt = $this->mysqlConnection->prepare($sql);
        $stmt->execute([$userId]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [
            'pode_gerenciar_permissao' => 0,
            'pode_gerenciar_usuarios' => 0,
            'pode_gerenciar_bi_frames' => 0
        ];
    }

    // Atualiza ou insere permissões gerais e de Bi para um usuário
    public function updateGeneralPermissions(int $targetUserId, array $permissions): void
    {
        // Garante apenas valores 0 ou 1
        $podeGerenciarUsuarios      = !empty($permissions['pode_gerenciar_usuarios']) ? 1 : 0;
        $podeGerenciarBiFrames      = !empty($permissions['pode_gerenciar_bi_frames']) ? 1 : 0;
        $podeGerenciarPermissao    = !empty($permissions['pode_gerenciar_permissao']) ? 1 : 0;

        // Verifica se já existe registro para o usuário
        $stmt = $this->mysqlConnection->prepare("
            SELECT COUNT(*) 
            FROM permissoes 
            WHERE user_id = ?
        ");

        $stmt->execute([$targetUserId]);
        $exists = $stmt->fetchColumn() > 0;

        if ($exists) {
            // UPDATE
            $stmt = $this->mysqlConnection->prepare("
                UPDATE permissoes
                SET
                    pode_gerenciar_usuarios = ?,
                    pode_gerenciar_bi_frames = ?,
                    pode_gerenciar_permissao = ?
                WHERE user_id = ?
            ");
            $stmt->execute([
                $podeGerenciarUsuarios,
                $podeGerenciarBiFrames,
                $podeGerenciarPermissao,
                $targetUserId
            ]);
        } else {
            // INSERT
            $stmt = $this->mysqlConnection->prepare("
                INSERT INTO permissoes (
                    user_id,
                    pode_gerenciar_usuarios,
                    pode_gerenciar_bi_frames,
                    pode_gerenciar_permissao
                ) VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([
                $targetUserId,
                $podeGerenciarUsuarios,
                $podeGerenciarBiFrames,
                $podeGerenciarPermissao
                
            ]);
        }
    }

    // Verifica se o usuario tem permissão a acessar a tela, caso não tenha, redireciona a outra pagina.
    public function accessDenied($condicao){
        if($this->isMaster()){
            return true;
        }

        if(empty($condicao)){
            ?>
            <script>
                window.location.href = "<?= BASE_URL ?>d/accessDenied";
            </script>
            <?php 
                exit; 

        }
        
    }

    
}
