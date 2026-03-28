<?php

require_once __DIR__ . '/../../notes-app/vendor/autoload.php';

use OOP\Interfaces\Drawable;
use OOP\Interfaces\Descriptable;
use OOP\Interfaces\Car;

echo "=== Le Interfacce ===\n\n";

// Test 1: Creare un'auto (implementa 2 interfacce)
echo "--- Test 1: Creazione di un'auto ---\n";
$auto = new Car('Ferrari', 'F8 Tributo', 'rosso');
echo "Auto creata: " . $auto->describe() . "\n\n";

// Test 2: Usare il metodo draw() (da interfaccia Drawable)
echo "--- Test 2: Metodi da Drawable ---\n";
echo $auto->draw() . "\n";
$auto->erase();
echo "\n";

// Test 3: Usare il metodo describe() e getInfo() (da interfaccia Descriptable)
echo "--- Test 3: Metodi da Descriptable ---\n";
echo "Descrizione: " . $auto->describe() . "\n";
$info = $auto->getInfo();
echo "Info completo:\n";
foreach ($info as $key => $value) {
    echo "  - $key: $value\n";
}
echo "\n";

// Test 4: Type hinting con interfacce
echo "--- Test 4: Type hinting con interfaccie ---\n";

// Funzione che accetta qualsiasi oggetto che implementa Drawable
function visualizzaOggetto(Drawable $oggetto): void
{
    echo "Visualizzazione: " . $oggetto->draw() . "\n";
}

// Funzione che accetta qualsiasi oggetto che implementa Descriptable
function mostraDettagli(Descriptable $oggetto): void
{
    echo "Dettagli: " . $oggetto->describe() . "\n";
}

visualizzaOggetto($auto);
mostraDettagli($auto);
echo "\n";

// Test 5: Array di oggetti che implementano un'interfaccia
echo "--- Test 5: Array di Drawable diversi ---\n";
$autos = [
    new Car('Lamborghini', 'Huracan', 'blu'),
    new Car('Mercedes', 'SLS', 'nero'),
    new Car('BMW', 'M5', 'grigio'),
];

foreach ($autos as $index => $auto) {
    echo ($index + 1) . ". " . $auto->draw() . "\n";
}
echo "\n";

// Test 6: Verificare se un oggetto implementa un'interfaccia
echo "--- Test 6: Verificare se un oggetto implementa un'interfaccia ---\n";
$ferrari = new Car('Ferrari', 'Portofino', 'rosso');
echo "La Ferrari implementa Drawable? " . (($ferrari instanceof Drawable) ? "Sì ✓" : "No ✗") . "\n";
echo "La Ferrari implementa Descriptable? " . (($ferrari instanceof Descriptable) ? "Sì ✓" : "No ✗") . "\n";
echo "\n";

echo "=== Concetto Chiave ===\n";
echo "Le interfacce definiscono UN CONTRATTO: 'Se implementi me, devi avere questi metodi'.\n";
echo "Una classe può implementare PIÙ interfacce contemporaneamente.\n";
echo "Le interfacce permettono di usare il polimorfismo anche senza eredità.\n";
