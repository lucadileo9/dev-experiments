<?php

namespace OOP\Encapsulation;

// APPROCCIO 1: Incapsulamento Semplice
// Usa private per proteggere le proprietà
// Getter e setter semplici senza validazione nella logica di business

class BankAccount
{
    // Proprietà private: accessibili SOLO da dentro la classe
    private string $holder;
    private float $balance;

    public function __construct(string $holder, float $balance)
    {
        $this->holder = $holder;
        $this->balance = $balance;
    }

    // Getter: metodo pubblico per LEGGERE la proprietà privata
    public function getHolder(): string
    {
        return $this->holder;
    }

    // Setter: metodo pubblico per MODIFICARE la proprietà privata
    public function setHolder(string $holder): void
    {
        $this->holder = $holder;
    }

    // Getter
    public function getBalance(): float
    {
        return $this->balance;
    }

    // Setter
    public function setBalance(float $balance): void
    {
        $this->balance = $balance;
    }

    // Metodi aggiuntivi di business logic
    public function deposit(float $amount): void
    {
        $this->balance += $amount;
    }

    public function withdraw(float $amount): void
    {
        if ($amount <= $this->balance) {
            $this->balance -= $amount;
        }
    }
}
