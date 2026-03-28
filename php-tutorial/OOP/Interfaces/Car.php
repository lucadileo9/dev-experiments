<?php

namespace OOP\Interfaces;

// Car implementa ENTRAMBE le interfacce: Drawable e Descriptable
// Questo si chiama "implementazione multipla di interfacce"
// Significa che Car DEVE implementare TUTTI i metodi da entrambe le interfacce

class Car implements Drawable, Descriptable
{
    public function __construct(
        public string $brand,
        public string $model,
        public string $color
    ) {}

    // === Metodi richiesti da Drawable ===

    public function draw(): string
    {
        return "🚗 [Disegno $this->brand $this->model in $this->color]";
    }

    public function erase(): void
    {
        echo "❌ [Auto cancellata dal foglio]\n";
    }

    // === Metodi richiesti da Descriptable ===

    public function describe(): string
    {
        return "$this->brand $this->model, colore $this->color";
    }

    public function getInfo(): array
    {
        return [
            'brand' => $this->brand,
            'model' => $this->model,
            'color' => $this->color,
            'description' => $this->describe(),
        ];
    }
}
