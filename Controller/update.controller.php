<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['update-user'])) {

        $user = $database->query(
            query: "SELECT * FROM users WHERE id = :id",
            class: User::class,
            params: [
                'id' => $_SESSION['user-id']
            ]
        )->fetch();

        if (!password_verify($currentPassword, $user->password)) {
            $_SESSION['message'] = "Senha atual inválida";
            header('Location: /settings');
            exit;
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

        header('Location: /users?message=success');
        view('settings', compact('user'));
    }
}
