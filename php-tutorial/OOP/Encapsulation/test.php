<?php

require_once __DIR__ . '/../../notes-app/vendor/autoload.php';

use OOP\Encapsulation\BankAccount;
use OOP\Encapsulation\Product;
use OOP\Encapsulation\User;

echo "=== Incapsulamento (Getters & Setters) ===\n\n";

// ============= APPROCCIO 1: Incapsulamento Semplice =============
echo "--- APPROCCIO 1: BankAccount (Semplice) ---\n";
$account = new BankAccount('Mario Rossi', 1500.00);
echo "Titolare: " . $account->getHolder() . "\n";
echo "Saldo: €" . number_format($account->getBalance(), 2) . "\n";

// Deposito
$account->deposit(500);
echo "Dopo deposito di €500: €" . number_format($account->getBalance(), 2) . "\n";

// Prelievo
$account->withdraw(200);
echo "Dopo prelievo di €200: €" . number_format($account->getBalance(), 2) . "\n";

// Cambio titolare usando il setter
$account->setHolder('Luigi Bianchi');
echo "Nuovo titolare: " . $account->getHolder() . "\n";
echo "\n";

// ============= APPROCCIO 2: Incapsulamento con VALIDAZIONE =============
echo "--- APPROCCIO 2: Product (Con Validazione) ---\n";
$prodotto = new Product('SKU-001', 'Laptop', 999.99, 10);
echo "Prodotto: " . $prodotto->getName() . "\n";
echo "Prezzo: €" . number_format($prodotto->getPrice(), 2) . "\n";
echo "Quantità: " . $prodotto->getQuantity() . "\n";
echo "In magazzino? " . ($prodotto->isInStock() ? "Sì ✓" : "No ✗") . "\n";
echo "Valore totale: €" . number_format($prodotto->getTotalValue(), 2) . "\n";

// Prova a impostare un prezzo negativo
echo "\n>> Tentativo di impostare prezzo negativo...\n";
try {
    $prodotto->setPrice(-50);
    echo "ERROR: Non dovrebbe arrivare qui!\n";
} catch (\Exception $e) {
    echo "❌ Errore catturato: " . $e->getMessage() . "\n";
}

// Prova a impostare quantità negativa
echo "\n>> Tentativo di impostare quantità negativa...\n";
try {
    $prodotto->setQuantity(-5);
    echo "ERROR: Non dovrebbe arrivare qui!\n";
} catch (\Exception $e) {
    echo "❌ Errore catturato: " . $e->getMessage() . "\n";
}

// Riduzione di quantità valida
echo "\n>> Vendita di 3 pezzi...\n";
$prodotto->decreaseQuantity(3);
echo "Quantità dopo vendita: " . $prodotto->getQuantity() . "\n";

// Tentativo di vendere più di quanto disponibile
echo "\n>> Tentativo di vendere 20 pezzi (disponibili: " . $prodotto->getQuantity() . ")...\n";
try {
    $prodotto->decreaseQuantity(20);
    echo "ERROR: Non dovrebbe arrivare qui!\n";
} catch (\Exception $e) {
    echo "❌ Errore catturato: " . $e->getMessage() . "\n";
}
echo "\n";

// ============= APPROCCIO 3: Incapsulamento con PROPERTY HOOKS (PHP 8.4+) =============
echo "--- APPROCCIO 3: User (Property Hooks - Sintassi Moderna PHP 8.4+) ---\n";
$utente = new User('mario@example.com', 'password123', 'user');
echo "Email: " . $utente->email . "\n";
echo "Ruolo: " . $utente->role . "\n";

// Email valida - cambio OK
echo "\n>> Cambio email valida...\n";
$utente->email = 'mario.nuovo@example.com';
echo "Nuova email: " . $utente->email . "\n";

// Email non valida
echo "\n>> Tentativo di impostare email non valida...\n";
try {
    $utente->email = 'email-non-valida';
    echo "ERROR: Non dovrebbe arrivare qui!\n";
} catch (\Exception $e) {
    echo "❌ Errore catturato: " . $e->getMessage() . "\n";
}

// Password debole
echo "\n>> Tentativo di password debole (meno di 6 caratteri)...\n";
try {
    $utente->password = 'abc';
    echo "ERROR: Non dovrebbe arrivare qui!\n";
} catch (\Exception $e) {
    echo "❌ Errore catturato: " . $e->getMessage() . "\n";
}

// Password valida
echo "\n>> Impostazione password valida...\n";
$utente->password = 'nuova_password_sicura_123';
echo "✓ Password cambita\n";

// Verifica password
echo "\n>> Verifica password...\n";
echo "Password corretta? " . ($utente->verifyPassword('nuova_password_sicura_123') ? "Sì ✓" : "No ✗") . "\n";
echo "Password sbagliata? " . ($utente->verifyPassword('sbagliata') ? "Sì ✓" : "No ✗") . "\n";

// Nota: Non possiamo changeRole() perché non ha setter
echo "\n>> Nota: property role non ha setter! È read-only disponibile dal constructor.\n";
echo "Il ruolo può essere impostato solo nel constructor per sicurezza.\n";
echo "\n";

// ============= RIEPILOGO COMPARATIVO =============
echo "=== Riepilogo: Tre Approcci ad Incapsulamento ===\n";
echo "1. BankAccount (SEMPLICE): private properties + getter/setter base\n";
echo "   ✓ Facile da capire\n";
echo "   ✗ Nessuna validazione, chiunque può mettere valori wrong\n\n";

echo "2. Product (CON VALIDAZIONE): private properties + setter con logica\n";
echo "   ✓ Protegge i dati, come in una vera applicazione\n";
echo "   ✗ Più complesso, richiede exception handling\n\n";

echo "3. User (PROPERTY HOOKS PHP 8.4): sintassi moderna con get/set hook\n";
echo "   ✓ Pulito, leggibile, logica inline nella proprietà\n";
echo "   ✓ Supporta getter senza setter (password read-only)\n";
echo "   ✗ Richiede PHP 8.4+, backing field privata necessaria\n\n";

echo "Principio: ENCAPSULATION = Proteggere i dati interni della classe!\n";
echo "Non esponi le proprietà direttamente: usa sempre getter/setter (o property hooks).\n";
