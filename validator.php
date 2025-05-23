<?php

class Validator
{

    private $errors = [];

    // Valida os dados com base nas regras
    public function validate($rules, $data)
    {
        foreach ($rules as $field => $fieldRules) {
            foreach ($fieldRules as $rule) {
                $value = $data[$field] ?? '';
                $this->applyRule($rule, $field, $value, $data);
            }
        }
        return $this;
    }

    // Aplica cada regra individualmente
    private function applyRule($rule, $field, $value, $data)
    {
        if (strpos($rule, 'matches_hash:') === 0) {
            [$ruleName, $hash] = explode(':', $rule, 2);
            $this->matchesHash($field, $value, $hash);
        } elseif (strpos($rule, 'unique:') === 0) {
            [$ruleName, $key] = explode(':', $rule, 2);
            $existingValues = $data[$key] ?? [];
            $this->$ruleName($field, $value, $existingValues);
        } elseif (strpos($rule, ':') !== false) {
            [$ruleName, $param] = explode(':', $rule, 2);
            $this->$ruleName($field, $value, $param);
        } else {
            $this->$rule($field, $value);
        }
    }

    // Métodos de validação
    private function required($field, $value)
    {
        if (empty(trim($value))) {
            $this->errors[] = "O $field é obrigatório";
        }
    }

    private function email($field, $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "O $field é inválido";
        }
    }

    private function matchesHash($field, $password, $hash)
    {
        if (!password_verify($password, $hash)) {
            $this->errors[] = "A $field está incorreta";
        }
    }

    private function unique($field, $value, array $existingValues)
    {
        if (in_array($value, $existingValues)) {
            $this->errors[] = "O $field já está cadastrado";
        }
    }

    // Validar presença de, ao menos, um caractere especial
    private function strong($field, $value)
    {
        if (!strpbrk($value, '!@#$%^*&()')) {
            $this->errors[] = "O $field precisa ter no minimo um caracter especial";
        }
    }

    // Trata de uma regra que verifica se há um número mínimo de caracteres presentes na senha
    private function min($field, $value, $min)
    {
        if (strlen($value) < $min) {
            $this->errors[] = "O $field precisa ter no mínimo $min caracteres";
        }
    }

    // Trata de uma regra que verifica se há um número máximo de caracteres presentes na senha
    private function max($field, $value, $max)
    {
        if (strlen($value) > $max) {
            $this->errors[] = "O $field pode ter no máximo $max caracteres";
        }
    }

    // Verifica se há erros
    public function hasErrors()
    {
        return !empty($this->errors);
    }

    // Retorna os erros
    public function getErrors()
    {
        return $this->errors;
    }
}


// public $auths;

    // // Validação das regras conforme os dados trazidos de cada campo do formulário de cadastro
    // public static function validate($rules, $data)
    // {

    //     $auths = new self; // Inicializa a própria classe Auth

    //     // Percorre pelas regras de cada campo do formulário de cadastro
    //     foreach ($rules as $field => $fieldRules) {

    //         // Percorre pelas regras do respectivo campo
    //         foreach ($fieldRules as $rule) {

    //             $fieldValue = $data[$field]; // Valor trazido do respectivo campo sob o envio de dados pelo método $_POST

    //             // Checagem específica para saber se o nome da regra é 'confirmed'
    //             if ($rule == 'confirmed') {

    //                 $auths->$rule($field, $fieldValue, $data["{$field}_confirm"]);
    //             } elseif (str_contains($rule, ':')) { // Verifica se a regra contém ':' como caractere

    //                 $temp = explode(':', $rule); // divide a string em um array utilizando ':' como separador
    //                 $rule = $temp[0]; // Atribui a $rule a string referente ao nome da regra
    //                 $ruleN = $temp[1]; // Guarda a string referente ao número de caracteres no valor do campo
    //                 $auths->$rule($ruleN, $field, $fieldValue); // Chama a função min() e passa os parâmetros necessários para a validação da regra

    //             } else { // Caso contrário, a execução seguirá conforme as outras regras

    //                 $auths->$rule($field, $fieldValue);
    //             }
    //         }
    //     }

    //     return $auths; // Resultados das autenticações
    // }

    // // Exige presença de conteúdo no valor do campo
    // private function required($field, $value)
    // {
    //     if (strlen($value) == 0) {
    //         $this->auths[] = "O $field é obrigatório";
    //     }
    // }

    // // Validar o valor trazido do campo email, verificando se ele apresenta caracterísitcas de um email válido
    // private function email($field, $value)
    // {
    //     if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
    //         $this->auths[] = "O $field é inválido";
    //     }
    // }

    // private function unique($field, $value, $emails)
    // {
    //     foreach ($emails as $email) {
    //         if ($value == $email->email) {
    //             $this->auths[] = "O $field já está cadastrado";
    //         }
    //     }
    // }

    // // Checar se o email de confirmação é o mesmo do email
    // // private function confirmed($field, $value, $confirmationValue)
    // // {
    // //     if ($value != $confirmationValue) {
    // //         $this->auths[] = "O $field de confirmação esta diferente";
    // //     }
    // // }

    // // Validar presença de, ao menos, um caractere especial
    // private function strong($field, $value)
    // {
    //     if (!strpbrk($value, '!@#$%^*&()')) {
    //         $this->auths[] = "O $field precisa ter no minimo um caracter especial";
    //     }
    // }

    // // Trata de uma regra que verifica se há um número mínimo de caracteres presentes na senha
    // private function min($min, $field, $value)
    // {
    //     if (strlen($value) < $min) {
    //         $this->auths[] = "O $field precisa ter no mínimo $min caracteres";
    //     }
    // }

    // // Trata de uma regra que verifica se há um número máximo de caracteres presentes na senha
    // private function max($max, $field, $value)
    // {
    //     if (strlen($value) > $max) {
    //         $this->auths[] = "O $field pode ter no máximo $max caracteres";
    //     }
    // }

    // // Retorna os valores inválidos de $auths, se houver algum
    // public function notPassed()
    // {
    //     return sizeof($this->auths) > 0;
    // }