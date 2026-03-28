<?php
$page_title = "About";
include "partials/head.php";
include "partials/header.php";
?>

<div class="pt-32 text-center text-white">
    <h1 class="text-5xl font-bold">About Page</h1>
    <p class="mt-4 text-gray-400">Pagina <?=  $_SESSION['user']['email'] ?? 'Guest' ?> </p>
</div>

<?php include "partials/footer.php"; ?>