<?php

namespace OOP\Interfaces;

// Seconda interfaccia: un oggetto che è descrivibile

interface Descriptable
{
    // Qualsiasi classe che implementa Descriptable DEVE avere questi metodi
    public function describe(): string;

    public function getInfo(): array;
}
