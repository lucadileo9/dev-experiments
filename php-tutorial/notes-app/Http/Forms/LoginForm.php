<?php

namespace Http\Forms;

use Core\Validator;

class LoginForm
{
    protected $errors = [];

    public function validate($email, $password)
    {
        $this->errors = [];

        if (!Validator::validateEmail($email)) {
            $this->errors['email'] = 'A valid email is required.';
        }

        if (!Validator::validatePassword($password)) {
            $this->errors['password'] = 'A password of at least 6 characters is required.';
        }

        return empty($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }
}
