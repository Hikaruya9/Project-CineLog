<?php

class Validator
{

    private $errors = [];

    // Valida os dados com base nas regras
    public function validate($rules, $data)
    {
        foreach ($rules as $field => $fieldRules) {
            $value = $data[$field] ?? '';
            $skip = false;

            foreach ($fieldRules as $rule) {
                if ($skip) break;

                if ($rule === 'empty') {
                    if (is_array($value)) {
                        // Se for um arquivo, verifica se foi enviado
                        $skip = empty($value['name']);
                    } else {
                        // Se for texto, verifica se está vazio
                        $skip = empty(trim((string) $value));
                    }
                    continue;
                }

                $previousErrorCount = count($this->errors);
                $this->applyRule($rule, $field, $value, $data);
                $currentErrorCount = count($this->errors);

                // Se a aplicação da regra adicionou erros, parar validação desse campo
                if ($currentErrorCount > $previousErrorCount) {
                    break;
                }
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
            // Divide a regra em partes: "unique:users,email" vira ['users', 'email']
            [$ruleName, $params] = explode(':', $rule, 2);
            [$listKey, $property] = explode(',', $params);
            $objects = $data[$listKey] ?? []; // Obtém a lista de objetos (ex.: $data['users'] = array de User)
            $this->$ruleName($field, $value, $objects, $property);
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
            $this->errors[] = "O $field está incorreto";
        }
    }

    private function unique($field, $value, array $objects, $property)
    {
        foreach ($objects as $object) {
            // Acessa a propriedade do objeto (ex.: $user->email)
            if (isset($object->$property) && $object->$property === $value) {
                $this->errors[] = "O $field já está cadastrado";
                return;
            }
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
        if (gettype($value) === "string" && strlen($value) < $min) {
            $this->errors[] = "O $field precisa ter no mínimo $min caracteres";
        } elseif (gettype($value) === "integer" && $value < $min) {
            $this->errors[] = "O $field precisa ser um número acima de $min";
        }
    }

    // Trata de uma regra que verifica se há um número máximo de caracteres presentes na senha
    private function max($field, $value, $max)
    {
        if (gettype($value) === "string" && strlen($value) > $max) {
            $this->errors[] = "O $field pode ter no máximo $max caracteres";
        } elseif (gettype($value) === "integer" && $value > $max) {
            $this->errors[] = "O $field precisa ser um número abaixo de $max";
        }
    }

    private function image($field, $file)
    {
        // Verifica erros de upload
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $this->errors[] = "Erro no upload do $field";
            return;
        }

        // Tipos permitidos
        $allowedTypes = ['image/jpeg', 'image/png'];
        $detectedType = mime_content_type($file['tmp_name']);

        if (!in_array($detectedType, $allowedTypes)) {
            $this->errors[] = "O $field deve ser uma imagem (JPG, PNG)";
        }

        // Tamanho máximo (2MB)
        if ($file['size'] > 2 * 1024 * 1024) {
            $this->errors[] = "O $field deve ter no máximo 2MB";
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
