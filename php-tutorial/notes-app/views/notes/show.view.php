<?php
$page_title = "Contact";
include base_path("views/partials/head.php");
include base_path("views/partials/header.php");
?>

<div class="pt-32 text-center text-white">
    <h1 class="text-5xl font-bold mb-4">Single Note</h1>
<?php
    echo "<li>" . $note['content'] . "</li>";
?>

        <p class="mb-6">
            <a href="/notes" class="text-blue-500 underline">go back...</a>
        </p>

                    <a href="/note/edit?id=<?= $note['id'] ?>" class="inline-flex justify-center rounded-md border border-transparent bg-gray-500 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Edit</a>
                    
        <form class="mt-6" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="id" value="<?= $note['id'] ?>">
            <button class="text-sm text-red-500">Delete</button>
        </form>

</div>

<?php include base_path("views/partials/footer.php"); ?>