<?php
use Core\Database;
use Core\Session;
use Core\Validator;

view('/sessions/create.view.php', [
    'errors' => Session::get('errors')
]);