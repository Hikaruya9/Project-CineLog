<?php

require 'validator.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['update-user'])) {

        $validator = new Validator();

        // Busca o usuário atual
        $user = $database->query(
            query: "SELECT id, username, email, password, avatar FROM users WHERE id = :id",
            class: User::class,
            params: ['id' => $_SESSION['user-id']]
        )->fetch();

        $data = $_POST;

        // Busca emails de outros usuários (excluindo o atual)
        $usersEmails = $database->query(
            query: "SELECT email FROM users WHERE id != :id",
            class: User::class,
            params: ['id' => $_SESSION['user-id']]
        )->fetchAll();

        // Passa a lista de objetos User para o Validator
        $data['users_emails'] = $usersEmails;

        $data['avatar'] = $_FILES['avatar'] ?? null;

        // Define as regras
        $rules = [
            'username' => ['required'],
            'email' => ['required', 'email', 'unique:users_emails,email'], // Verifica a propriedade 'email' dos objetos
            'current-password' => ['required', "matches_hash:{$user->password}"], // Valida hash
            'new-password' => ['empty', 'strong', 'min:8', 'max:64'],
            'avatar' => ['empty', 'image']
        ];

        // Executa a validação
        $validationResult = $validator->validate($rules, $data);

        if ($validationResult->hasErrors()) {
            $_SESSION['auth'] = $validationResult->getErrors();
            header('Location: /settings'); // Redireciona de volta para a página de edição
            exit();
        }

        // Atualiza os dados no banco
        $params = [
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'id' => $_SESSION['user-id']
        ];

        $fields = "username = :username, email = :email";

        // Se nova senha for fornecida
        if (!empty($_POST['new-password'])) {
            $params['password'] = password_hash($_POST['new-password'], PASSWORD_DEFAULT);
            $fields .= ", password = :password";
        }

        $avatarPath = $user->avatar;

        if (!empty($_FILES['avatar']['name'])) {
            $uploadDir = 'uploads/avatars/';
            $filename = uniqid() . '_' . basename($_FILES['avatar']['name']);
            $targetPath = $uploadDir . $filename;

            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetPath)) {
                // Apagar avatar antigo se não for o default
                if ($user->avatar !== ($uploadDir . 'avatar_default.jpg')) {
                    @unlink($user->avatar);
                }
                $avatarPath = $targetPath;
                $params['avatar'] = $avatarPath;
                $fields .= ", avatar = :avatar";
            }
            // dd($avatarPath);
        }

        $database->query(
            query: "UPDATE users SET $fields WHERE id = :id",
            params: $params
        );

        $_SESSION['auth'][] = "Perfil atualizado com sucesso!";
        header('Location: /settings');
        exit();
    }
}