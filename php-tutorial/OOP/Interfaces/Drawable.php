<?php

namespace OOP\Interfaces;

// Un'interfaccia è un "contratto" che specifica quali metodi DEVONO essere implementati
// Una interfaccia NON contiene implementazione (nessun codice dentro i metodi)
// Le interfacce servono per dire: "Qualsiasi classe che implementa me, DEVE avere questi metodi"

interface Drawable
{
    // Qualsiasi classe che implementa Drawable DEVE avere questi metodi
    public function draw(): string;

    public function erase(): void;
}
