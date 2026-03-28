<?php

use Core\Response;
use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

$note = $db->query('select * from notes where id = :id', ['id' => $_GET['id']])->findOrFail();


if ($note['user_id'] !== 1) {
    abort(Response::FORBIDDEN);
}

view('/notes/edit.view.php', [
    'errors' => [],
    'note' => $note
]);