<?php

namespace OOP\AbstractClasses;

// Circle eredita da Shape (classe astratta)
// DEVE implementare TUTTI i metodi astratti di Shape

class Circle extends Shape
{
    private float $radius;

    public function __construct(float $radius, string $color)
    {
        // Chiama il constructor della classe madre
        parent::__construct($color);
        $this->radius = $radius;
    }

    // Getter e setter per il raggio
    public function getRadius(): float
    {
        return $this->radius;
    }

    public function setRadius(float $radius): void
    {
        $this->radius = $radius;
    }

    // Implementazione obbligatoria di calculateArea() (metodo astratto di Shape)
    public function calculateArea(): float
    {
        // Formula: π * r²
        return pi() * $this->radius ** 2;
    }

    // Implementazione obbligatoria di describe() (metodo astratto di Shape)
    public function describe(): string
    {
        return "Cerchio con raggio {$this->radius}cm, colore {$this->color}, area: " . number_format($this->calculateArea(), 2) . " cm²";
    }
}
