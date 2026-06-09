<?php

namespace Config;

class Mask {

    /**
     * Formata data para o padrão brasileiro (dd/mm/aaaa)
     */
    public function data($data) {
        if (empty($data)) {
            return "N/A";
        }

        try {
            return (new \DateTime($data))->format('d/m/Y');
        } catch (\Exception $e) {
            return $data; // Retorna a string original se a data for inválida
        }
    }

    /**
     * Formatação padrão para cnpj 
     */
    public function formatarCnpj($cnpj) {

        $cnpj = preg_replace("/[^0-9]/", "", $cnpj);
        
        if (strlen($cnpj) === 14) {
            return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "$1.$2.$3/$4-$5", $cnpj);
        }
        
        return $cnpj; // Retorna original se não for válido
    }

    /**
     * Formatação padrão para numero de telefone
     */
    public function maskTelefone($telefone): string
    {
        // Guarda original para fallback
        $original = $telefone;

        // Remove tudo que não for número
        $digits = preg_replace('/\D/', '', $telefone);

        switch (strlen($digits)) {
            // (DDD) X XXXX-XXXX
            case 11:
                return sprintf(
                    '(%s) %s %s-%s',
                    substr($digits, 0, 2),
                    substr($digits, 2, 1),
                    substr($digits, 3, 4),
                    substr($digits, 7, 4)
                );

            // (DDD) XXXX-XXXX
            case 10:
                return sprintf(
                    '(%s) %s-%s',
                    substr($digits, 0, 2),
                    substr($digits, 2, 4),
                    substr($digits, 6, 4)
                );

            // X XXXX-XXXX
            case 9:
                return sprintf(
                    '%s %s-%s',
                    substr($digits, 0, 1),
                    substr($digits, 1, 4),
                    substr($digits, 5, 4)
                );

            // XXXX-XXXX
            case 8:
                return sprintf(
                    '%s-%s',
                    substr($digits, 0, 4),
                    substr($digits, 4, 4)
                );

            // Qualquer outro tamanho → retorna como está no banco
            default:
                return $original;
        }
    }



}