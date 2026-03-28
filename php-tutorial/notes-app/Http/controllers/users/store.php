<?php

use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);

$errors = [];

if (! Validator::validateEmail($_POST['email'])) {
    $errors['email'] = 'A valid email is required.';
}

if (! Validator::validatePassword($_POST['password'])) {
    $errors['password'] = 'A password of at least 6 characters is required.';
}

if (! empty($errors)) {
    return view("users/create.view.php", [
        'heading' => 'Create User',
        'errors' => $errors
    ]);
}

$db->query('INSERT INTO users(email, password) VALUES(:email, :password)', [
    'email' => $_POST['email'],
    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
]);

$_SESSION['user'] = $_POST['email'];

header('location: /notes');
die();