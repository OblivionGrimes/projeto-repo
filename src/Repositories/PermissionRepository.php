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
