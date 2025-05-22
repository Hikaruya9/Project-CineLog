<?php

// $protectedRoutes = ['/users', '/settings', '/logout', '/update', '/delete']; // Páginas protegidas contra acesso não autenticado, direciona o usuário novamente para a página inicial
// $RoutesRedirect = ['/sign-in', '/sign-up', '/login']; // Redireciona o usuário autenticado caso ele tente acessar essas páginas estando logado

// if (in_array($_SERVER['REQUEST_URI'], $protectedRoutes)) {
//     requireAuth();
// } elseif (in_array($_SERVER['REQUEST_URI'], $RoutesRedirect)) {
//     redirectIfAuthenticated();
// }


class Auth
{
    function requireAuth()
    {
        if (!isset($_SESSION['user-id'])) {
            // Redireciona para a página de login
            header('Location: /');
            exit;
        }
    }

    function redirectIfAuthenticated()
    {
        if (isset($_SESSION['user-id'])) {
            header('Location: /profile');
            exit;
        }
    }
}

class AuthUser
{

    public $auths;

    // Validação das regras conforme os dados trazidos de cada campo do formulário de cadastro
    public static function validate($rules, $data)
    {

        $auths = new self; // Inicializa a própria classe Auth

        // Percorre pelas regras de cada campo do formulário de cadastro
        foreach ($rules as $field => $fieldRules) {

            // Percorre pelas regras do respectivo campo
            foreach ($fieldRules as $rule) {

                $fieldValue = $data[$field]; // Valor trazido do respectivo campo sob o envio de dados pelo método $_POST

                // Checagem específica para saber se o nome da regra é 'confirmed'
                if ($rule == 'confirmed') {

                    $auths->$rule($field, $fieldValue, $data["{$field}_confirm"]);
                } elseif (str_contains($rule, ':')) { // Verifica se a regra contém ':' como caractere

                    $temp = explode(':', $rule); // divide a string em um array utilizando ':' como separador
                    $rule = $temp[0]; // Atribui a $rule a string referente ao nome da regra
                    $ruleN = $temp[1]; // Guarda a string referente ao número de caracteres no valor do campo
                    $auths->$rule($ruleN, $field, $fieldValue); // Chama a função min() e passa os parâmetros necessários para a validação da regra

                } else { // Caso contrário, a execução seguirá conforme as outras regras

                    $auths->$rule($field, $fieldValue);
                }
            }
        }

        return $auths; // Resultados das autenticações
    }

    // Exige presença de conteúdo no valor do campo
    private function required($field, $value)
    {
        if (strlen($value) == 0) {
            $this->auths[] = "O $field é obrigatório";
        }
    }

    // Validar o valor trazido do campo email, verificando se ele apresenta caracterísitcas de um email válido
    private function email($field, $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->auths[] = "O $field é inválido";
        }
    }

    private function unique($field, $value, $emails)
    {
        foreach ($emails as $email) {
            if ($value == $email->email) {
                $this->auths[] = "O $field já está cadastrado";
            }
        }
    }

    // Checar se o email de confirmação é o mesmo do email
    // private function confirmed($field, $value, $confirmationValue)
    // {
    //     if ($value != $confirmationValue) {
    //         $this->auths[] = "O $field de confirmação esta diferente";
    //     }
    // }

    // Validar presença de, ao menos, um caractere especial
    private function strong($field, $value)
    {
        if (!strpbrk($value, '!@#$%^*&()')) {
            $this->auths[] = "O $field precisa ter no minimo um caracter especial";
        }
    }

    // Trata de uma regra que verifica se há um número mínimo de caracteres presentes na senha
    private function min($min, $field, $value)
    {
        if (strlen($value) < $min) {
            $this->auths[] = "O $field precisa ter no mínimo $min caracteres";
        }
    }

    // Trata de uma regra que verifica se há um número máximo de caracteres presentes na senha
    private function max($max, $field, $value)
    {
        if (strlen($value) > $max) {
            $this->auths[] = "O $field pode ter no máximo $max caracteres";
        }
    }

    // Retorna os valores inválidos de $auths, se houver algum
    public function notPassed()
    {
        return sizeof($this->auths) > 0;
    }
}


// Adicionar uma autenticação para veriricar se o email cadastrado já não se encontra no BD