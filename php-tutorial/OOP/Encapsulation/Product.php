<?php

namespace OOP\Encapsulation;

// APPROCCIO 2: Incapsulamento con VALIDAZIONE
// Usa private per proteggere le proprietà
// Setter hanno logica di validazione per rifiutare valori non validi

class Product
{
    private string $sku;
    private string $name;
    private float $price;
    private int $quantity;

    public function __construct(string $sku, string $name, float $price, int $quantity)
    {
        $this->sku = $sku;
        $this->name = $name;
        // Usa il setter per applicare la validazione même nel constructor
        $this->setPrice($price);
        $this->setQuantity($quantity);
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        if (empty($name)) {
            throw new \Exception("Nome prodotto non può essere vuoto");
        }
        $this->name = $name;
    }

    // Getter per price
    public function getPrice(): float
    {
        return $this->price;
    }

    // Setter con VALIDAZIONE: prezzo non può essere negativo
    public function setPrice(float $price): void
    {
        if ($price < 0) {
            throw new \Exception("Prezzo non può essere negativo! Ricevuto: $price");
        }
        $this->price = $price;
    }

    // Getter per quantity
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    // Setter con VALIDAZIONE: quantità non può essere negativa
    public function setQuantity(int $quantity): void
    {
        if ($quantity < 0) {
            throw new \Exception("Quantità non può essere negativa! Ricevuta: $quantity");
        }
        $this->quantity = $quantity;
    }

    // Getter con LOGICA: non è solo una proprietà, calcola qualcosa
    public function isInStock(): bool
    {
        return $this->quantity > 0;
    }

    public function getTotalValue(): float
    {
        return $this->price * $this->quantity;
    }

    public function decreaseQuantity(int $amount): void
    {
        if ($amount > $this->quantity) {
            throw new \Exception("Quantità richiesta ($amount) superiore al disponibile ({$this->quantity})");
        }
        $this->quantity -= $amount;
    }
}
