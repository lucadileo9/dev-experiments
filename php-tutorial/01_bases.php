<!DOCTYPE html>
<tml lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Website</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="icon" href="./favicon.ico" type="image/x-icon">
  </head>
  <body>
    <main>

        <h1>
          <?php
              $var = "Books";
              echo "List of $var!";

              $books =[
                "Book 1",
                "Book 2",
                "Book 3",
              ]
          ?>
          <?= $var ?>

          <ul>
            <?php
              foreach ($books as $book)
                {
                  echo "<li> $book </li>";
                }
          ?>
          </ul>

          <ul>
            <?php foreach ($books as $book): ?>
                <li> <?= $book ?> </li>
          <?php endforeach; ?>
          </ul>

          <?php
          $persone = [
    ["nome" => "Luca", "eta" => 25],
    ["nome" => "Marco", "eta" => 30],
    ["nome" => "Anna", "eta" => 22]
];
echo $persone[0]["nome"];  // Output: Luca
          ?>

        </h1>
    </main>
    <script src="index.js"></script>
  </body>
</html>
