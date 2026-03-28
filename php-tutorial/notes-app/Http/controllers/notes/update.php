<?php

use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);

$currentUserId = 1;

// find the corresponding note
$note = $db->query('select * from notes where id = :id', [
    'id' => $_POST['id']
])->findOrFail();

// authorize that the current user can edit the note
if ($note['user_id'] != $currentUserId) {
    die('Not authorized');
}
// validate the form
$errors = [];

if (! Validator::validateNoteContent($_POST['content'], 1, 10)) {
    $errors['content'] = 'A content of no more than 1,000 characters is required.';
}

// if no validation errors, update the record in the notes database table.
if (count($errors)) {
    return view('notes/edit.view.php', [
        'heading' => 'Edit Note',
        'errors' => $errors,
        'note' => $note
    ]);
}

$db->query('update notes set content = :content where id = :id', [
    'id' => $_POST['id'],
    'content' => $_POST['content']
]);

// redirect the user
header('location: /notes');
die();