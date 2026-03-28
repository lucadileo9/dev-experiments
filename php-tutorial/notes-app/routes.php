<?php
// ROUTES
// return [
//     "/"          => "index.php",
//     "/about"     => "about.php",
//     "/contact"   => "contact.php",
//     "/notes"     => "notes/index.php",
//     "/note"     => "notes/show.php",
//     "/notes/create"     => "notes/create.php",
// ];

$router->get("/", "index.php");
$router->get("/about", "about.php");
$router->get("/contact", "contact.php");
$router->get("/notes", "notes/index.php")->middleware('auth');
$router->get("/note", "notes/show.php");
$router->get("/notes/create", "notes/create.php");

$router->post("/notes", "notes/store.php");
$router->delete("/note", "notes/destroy.php");

$router->get("/note/edit", "notes/edit.php");
$router->put("/note", "notes/update.php");

$router->get("/registration", "users/create.php")->middleware('guest');
$router->post("/registration", "users/store.php");

$router->get("/login", "sessions/create.php")->middleware('guest');
$router->post("/login", "sessions/store.php");
$router->delete("/logout", "sessions/destroy.php")->middleware('auth');