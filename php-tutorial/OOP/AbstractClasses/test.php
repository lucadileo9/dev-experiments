<?php

require_once __DIR__ . '/../../notes-app/vendor/autoload.php';

use OOP\AbstractClasses\Shape;
use OOP\AbstractClasses\Circle;
use OOP\AbstractClasses\Rectangle;

echo "=== Le Classi Astratte ===\n\n";

// Test 1: Perché non possiamo istanziare Shape direttamente?
echo "--- Test 1: Istanziazione di uma classe astratta ---\n";
echo "Se provi a fare: \$shape = new Shape('rosso'); otterrai un ERRORE!\n";
echo "Perché? Shape è astratta e serve solo come base per altre classi.\n";
echo "Non puoi istanziare una classe astratta direttamente.\n\n";

// Test 2: Creiamo un cerchio (estende Shape)
echo "--- Test 2: Creazione di un Cerchio ---\n";
$circle = new Circle(5.0, 'rosso');
echo "Cerchio creato: " . $circle->describe() . "\n\n";

// Test 3: Creiamo un rettangolo (estende Shape)
echo "--- Test 3: Creazione di un Rettangolo ---\n";
$rectangle = new Rectangle(10.0, 7.0, 'blu');
echo "Rettangolo creato: " . $rectangle->describe() . "\n\n";

// Test 4: Polimorfismo! Mettiamo diverse forme in un array
echo "--- Test 4: Polimorfismo (array di Shape diverse) ---\n";
$shapes = [
    new Circle(3.0, 'giallo'),
    new Rectangle(5.0, 8.0, 'verde'),
    new Circle(2.5, 'viola'),
    new Rectangle(6.0, 4.0, 'arancione'),
];

echo "Descrizioni di tutte le forme:\n";
$totalArea = 0;
foreach ($shapes as $index => $shape) {
    echo ($index + 1) . ". " . $shape->describe() . "\n";
    $totalArea += $shape->calculateArea();
}
echo "\nArea totale di tutte le forme: " . number_format($totalArea, 2) . " cm²\n\n";

// Test 5: Cambio colore usando il metodo ereditato da Shape
echo "--- Test 5: Modifica proprietà ereditata ---\n";
$circle->setColor('rosa');
echo "Nuovo colore del cerchio: " . $circle->getColor() . "\n";
echo "Descrizione aggiornata: " . $circle->describe() . "\n\n";

// Test 6: Modifiche specifiche delle sottoclassi
echo "--- Test 6: Modifica proprietà specifiche di Rectangle ---\n";
$rectangle->setWidth(15.0);
$rectangle->setHeight(10.0);
echo "Rettangolo ridimensionato: " . $rectangle->describe() . "\n\n";

echo "=== Concetto Chiave ===\n";
echo "Le classi astratte permettono di definire un'interfaccia comune (Shape)\n";
echo "mentre le sottoclassi (Circle, Rectangle) implementano il comportamento specifico.\n";
echo "Questo è il POLIMORFISMO: stessi metodi, implementazioni diverse!\n";
