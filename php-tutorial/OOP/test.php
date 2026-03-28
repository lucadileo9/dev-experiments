<?php

require_once __DIR__ . '/../notes-app/vendor/autoload.php';

use OOP\Song;
use OOP\Playlist;

// Test 1: Crea una singola canzone
echo "=== Test 1: Creazione Song ===\n";
$song1 = new Song('My Heart Will Go On', 'Celine Dion');
echo "Canzone: {$song1->name} - {$song1->artist}\n\n";


// Test 2: Crea una playlist
echo "=== Test 2: Creazione Playlist ===\n";
$songs = [
    new Song('My Heart Will Go On', 'Celine Dion'),
    new Song('I Will Always Love You', 'Whitney Houston'),
    new Song('Unchained Melody', 'The Righteous Brothers'),
];

$playlist = new Playlist('90s Movie Soundtracks', $songs);
echo "Playlist: {$playlist->name}\n";
echo "Numero canzoni: " . count($playlist->songs) . "\n\n";


// Test 3: Stampa tutte le canzoni
echo "=== Test 3: Elenco Canzoni ===\n";
foreach ($playlist->songs as $index => $song) {
    echo ($index + 1) . ". {$song->name} - {$song->artist}\n";
}
echo "\n";


// Test 4: Modifica proprietà (public) - dimostra che sono accessibili
echo "=== Test 4: Modifica Proprietà ===\n";
$playlist->name = 'Le Migliori Colonne Sonore';
echo "Nome playlist aggiornato: {$playlist->name}\n";
