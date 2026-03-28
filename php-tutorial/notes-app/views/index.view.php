<?php
require 'partials/head.php';
require 'partials/header.php';
?>


<div class="pt-32 text-center text-white">
    <?php if ($_SESSION['user'] ?? false): ?>
        <h1 class="text-5xl font-bold">Benvenuto, <?php echo htmlspecialchars($_SESSION['user']['email']); ?>!</h1>
        <p class="mt-4 text-gray-400">Inizia a creare o visualizzare le tue note</p>
        <a href="/notes" class="inline-block mt-6 rounded-md bg-indigo-600 px-4 py-2 text-sm/6 font-semibold text-white hover:bg-indigo-500 transition">
            Accedi alle tue note
        </a>
    <?php else: ?>
        <h1 class="text-5xl font-bold">Home Page</h1>
        <p class="mt-4 text-gray-400">Pagina vuota</p>
        <div class="mt-6 flex gap-4 justify-center">
            <a href="/login" class="rounded-md bg-indigo-600 px-4 py-2 text-sm/6 font-semibold text-white hover:bg-indigo-500 transition">
                Accedi
            </a>
            <a href="/registration" class="rounded-md border border-indigo-600 px-4 py-2 text-sm/6 font-semibold text-indigo-400 hover:bg-indigo-600/10 transition">
                Registrati
            </a>
        </div>
    <?php endif; ?>
</div>

<?php require "partials/footer.php"; ?>