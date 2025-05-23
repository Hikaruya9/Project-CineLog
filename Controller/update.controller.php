<?php

require 'validator.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['update-user'])) {
        
        $user = $database->query(
            query: "SELECT id,username,email,password,avatar FROM users WHERE id = :id",
            class: User::class,
            params: [
                'id' => $_SESSION['user-id']
            ]
        )->fetch();

        $data = $_POST;

        $existingEmails = $database->query(
            query: "SELECT email FROM users WHERE id != :id",
            class: User::class,
            params: [
                'id' => $_SESSION['user-id']
            ]
        )->fetchAll();

        $data['existing_emails'] = $existingEmails;

        $rules = [
            'username' => ['required'],
            'email' => ['required', 'email', 'unique:existing_emails'],
            'current-password' => ['required', "matches_hash:{$user->password}"],
            'new-password' => ['strong', 'min:8', 'max:64']
        ];

        $validationResult = $validator->validate($rules, $data);

        if ($validationResult->hasErrors()) {
            $_SESSION['auth'] = $validationResult->getErrors();
            header('Location: /sign-up');
            exit();
        }

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

        // Se uma nova imagem for enviada
        // if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        //     $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
        //     $fileName = $_FILES['profile_picture']['name'];
        //     $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        //     $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        //     if (in_array(strtolower($fileExtension), $allowedExtensions)) {
        //         $newFileName = 'user_' . $id . '_' . time() . '.' . $fileExtension;
        //         $destination = 'uploads/profiles/' . $newFileName;

        //         if (move_uploaded_file($fileTmpPath, $destination)) {
        //             $params['avatar'] = $destination;
        //             $fields .= ", profile_picture = :avatar";
        //         }
        //     }
        // }

        $database->query(
            query: "UPDATE users SET $fields WHERE id = :id",
            params: $params
        );

        $_SESSION['auth'] = "Perfil atualizado com sucesso!";
        header('Location: /settings');
        view('settings', compact('user'));
    }
}
