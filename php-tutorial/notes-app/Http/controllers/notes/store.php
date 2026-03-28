<?php
// questo file dovendo gestire la logica di salvataggio di una nuova nota, 
// non necessita nessuna view, ma solo di un redirect alla pagina delle note dopo aver salvato la nuova nota nel database

use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);

$errors = [];
// N.B: non è necessario controllare il tipo di richiesta, in quanto questa rotta 
// è raggiungibile solo tramite un form che invia una POST request
if (! Validator::validateNoteContent($_POST['content'], 1, 1000)) {
    $errors['content'] = 'A content of no more than 1,000 characters is required.';
}

if (! empty($errors)) {
    return view("notes/create.view.php", [
        'heading' => 'Create Note',
        'errors' => $errors
    ]);
}

$db->query('INSERT INTO notes(content, user_id) VALUES(:content, :user_id)', [
    'content' => $_POST['content'],
    'user_id' => 1
]);

header('location: /notes');
die();