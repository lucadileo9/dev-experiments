<?php
require base_path("views/partials/head.php");
require base_path("views/partials/header.php");
?>

<div class="pt-32 text-center text-white">
    <h1 class="text-5xl font-bold">Notes Page</h1>
    <p class="mt-4 text-gray-400">Pagina vuota</p>
        <?php
        foreach ($notes as $note) : ?>
            <li>
                <a href="/note?id=<?= $note['id'] ?>" class="text-blue-500 hover:underline">
                    <?= $note['content'] ?>
                </a>
            </li>
        <?php endforeach; ?>

        <button class="mt-4 inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <a href="/notes/create">Create Note</a>
</div>

<?php require base_path("views/partials/footer.php"); ?>