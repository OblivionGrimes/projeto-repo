<?php

namespace src\Repositories;

use src\Core\Database;
use PDO;

require_once __DIR__ . '/../Core/Database.php';

class QueryRepository extends Database
{

    protected function update (string $table, string $set, string $where) {

        $setArray = explode(',', $set);
        $whereArray = explode(',', $where);
        
        $setParts = [];
        foreach($setArray as $column => $value){
            $setParts[] = "{$column} = ?"; 
        }
        $setString = implode(', ', $setParts);

        $setWhere = [];
        foreach($whereArray as $column => $value){
            $setWhere[] = "{$column} = ?";
        }
        $whereString = implode(' AND ', $setWhere);

        $sql = "UPDATE {$table} SET {$setString} WHERE {$whereString}";

        $values = array_merge(array_values($setArray), array_values($whereArray));

        $stmt = $this->mysqlConnection->prepare($sql);
        return $stmt->execute($values);

    }

    #-- EX: $this->insert('recovery_keys', 'key_recover, email', "{$codigo}| {$email}")

    protected function insert (string $table, string $column, string $values){
        
        $total = count(explode(',', $column));
        $interrogacoes = '';

        for ($i = 1; $i <= $total; $i++){
            $interrogacoes .= ", ?"; 
        }

        $interrogacoes = substr($interrogacoes, 1);

        $valuesArray = array_map('trim', explode('|', $values));

        $sql = "INSERT INTO ". $table ." ( ". $column ." ) VALUES ( ". $interrogacoes ." )";

        $stmt = $this->mysqlConnection->prepare($sql);
        return $stmt->execute($valuesArray);

    }

    protected function delete (string $table, string $where) {

        $whereArray = explode(',', $where);
        $setWhere = [];
        foreach ($whereArray as $column => $value){
            $setWhere[] = "{$column} = ?";
        }

        $whereString = implode(' AND ', $setWhere);
        $sql = "DELETE FROM {$table} WHERE {$whereString}";

        $values = array_values($whereArray);

        $stmt = $this->mysqlConnection->prepare($sql);
        return $stmt->execute($values);

    }

    protected function select(string $table, string $columns, string $where = '', string $orderBy = '', string $limit = '')
    {
        $sql    = "SELECT {$columns} FROM {$table}";
        $values = [];

        if (!empty($where)) {
            $comparadores = ['>=', '<=', '!=', '<>', '>', '<', 'LIKE', 'like', '='];
            $partes       = explode(',', $where);
            $setWhere     = [];

            foreach ($partes as $parte) {
                $parte = trim($parte);
                $comparadorEncontrado = null;

                foreach ($comparadores as $comp) {
                    if (stripos($parte, $comp) !== false) {
                        $comparadorEncontrado = $comp;
                        break;
                    }
                }

                if ($comparadorEncontrado) {
                    [$column, $value] = explode($comparadorEncontrado, $parte, 2);
                    $setWhere[] = trim($column) . " {$comparadorEncontrado} ?";
                    $values[]   = trim($value);
                }
            }

            $sql .= " WHERE " . implode(' AND ', $setWhere);
        }

        if (!empty($orderBy)) $sql .= " ORDER BY {$orderBy}";
        if (!empty($limit))   $sql .= " LIMIT {$limit}";

        $stmt = $this->mysqlConnection->prepare($sql);
        $stmt->execute($values);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    protected function select_livre (string $sql){

        $stmt = $this->mysqlConnection->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);    

    }

}