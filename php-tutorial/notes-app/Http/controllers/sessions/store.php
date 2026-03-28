<?php 

use Core\Authenticator;
use Core\Session;

$authenticator = new Authenticator();
$result = $authenticator->attempt($_POST['email'], $_POST['password']);

if ($result['success']) {
    redirect('/');
}

// Store errors in flash for PRG pattern
Session::flash('errors', $result['errors']);
Session::flash('old', [
    'email' => $_POST['email']
]);
redirect('/login');

