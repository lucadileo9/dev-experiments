<?php

namespace OOP\AbstractClasses;

// Rectangle eredita da Shape (classe astratta)
// DEVE implementare TUTTI i metodi astratti di Shape

class Rectangle extends Shape
{
    private float $width;
    private float $height;

    public function __construct(float $width, float $height, string $color)
    {
        // Chiama il constructor della classe madre
        parent::__construct($color);
        $this->width = $width;
        $this->height = $height;
    }

    // Getter e setter per larghezza e altezza
    public function getWidth(): float
    {
        return $this->width;
    }

    public function setWidth(float $width): void
    {
        $this->width = $width;
    }

    public function getHeight(): float
    {
        return $this->height;
    }

    public function setHeight(float $height): void
    {
        $this->height = $height;
    }

    // Implementazione obbligatoria di calculateArea() (metodo astratto di Shape)
    public function calculateArea(): float
    {
        // Formula: larghezza * altezza
        return $this->width * $this->height;
    }

    // Implementazione obbligatoria di describe() (metodo astratto di Shape)
    public function describe(): string
    {
        return "Rettangolo {$this->width}x{$this->height}cm, colore {$this->color}, area: " . number_format($this->calculateArea(), 2) . " cm²";
    }
}
