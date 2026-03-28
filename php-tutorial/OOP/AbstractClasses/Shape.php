<?php

namespace OOP\AbstractClasses;

// Una classe astratta è una classe che non può essere istanziata direttamente.
// Serve come "template" o "blueprint" per altre classi che ereditano da essa.
// Le classi astratte possono avere metodi astratti (solo firma) e metodi concreti (implementazione completa).

abstract class Shape
{
    // Proprietà protetta: accessibile solo dalla classe e dalle sottoclassi
    protected string $color;

    public function __construct(string $color)
    {
        $this->color = $color;
    }

    // Metodo concreto (ha implementazione completa)
    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    // Metodi astratti: DEVONO essere implementati dalle sottoclassi
    // Non hanno corpo, solo firma
    abstract public function calculateArea(): float;

    abstract public function describe(): string;
}
