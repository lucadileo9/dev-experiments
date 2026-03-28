<?php

namespace Core;

use Core\App;
use Core\Database;
use Http\Forms\LoginForm;

class Authenticator
{
    protected $errors = [];

    public function attempt($email, $password)
    {
        // Validate form input
        $form = new LoginForm();

        if (!$form->validate($email, $password)) {
            return [
                'success' => false,
                'errors' => $form->errors()
            ];
        }

        // Check if user exists and password is correct
        $db = App::resolve(Database::class);

        $user = $db->query('SELECT * FROM users WHERE email = :email', [
            'email' => $email
        ])->find();

        if ($user && password_verify($password, $user['password'])) {
            $this->login([
                'email' => $user['email']
            ]);
            return ['success' => true];
        }

        return [
            'success' => false,
            'errors' => [
                'email' => 'No matching account found for that email address and password.'
            ]
        ];
    }

    public function logout()
    {
        $this->_logout();
    }

    private function login($data)
    {
        $_SESSION['user'] = $data;

        session_regenerate_id(true);
    }

    private function _logout()
    {
        $_SESSION = [];
        session_destroy();

        $params = session_get_cookie_params();
        setcookie('PHPSESSID', '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
}
