<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$notes = $db->query("select * from notes")->getAll();
view('/notes/index.view.php', ['notes' => $notes]);
