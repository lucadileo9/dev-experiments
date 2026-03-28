<?php

namespace OOP\Encapsulation;

// APPROCCIO 3b: Incapsulamento con PHP 8.4 PROPERTY HOOKS (sintassi moderna)
// I property hooks permettono di definire getter/setter direttamente sulla proprietà
// Questa è la sintassi più moderna e leggibile per incapsulamento in PHP 8.4+

class User
{
    // ========== Property Hook per EMAIL ==========
    // Public getter, setter con validazione
    public string $email {
        get => $this->_email;
        set {
            if (!$this->validateEmail($value)) {
                throw new \Exception("Email non valida: $value");
            }
            $this->_email = $value;
        }
    }
    private string $_email = '';

    // ========== Property Hook per PASSWORD ==========
    // NO getter (privacy! non esponiamo le password)
    // Setter con validazione
    public string $password {
        set {
            if (strlen($value) < 6) {
                throw new \Exception("Password deve essere almeno 6 caratteri");
            }
            $this->_password = password_hash($value, PASSWORD_DEFAULT);
        }
    }
    private string $_password = '';

    // ========== Property Hook per ROLE ==========
    // Public getter, setter privato per controllare il ruolo
    public string $role {
        get => $this->_role;
    }
    private string $_role;

    public function __construct(string $email, string $password, string $role = 'user')
    {
        // Usa i property hooks tramite assegnazione
        // Il set hook verrà eseguito automaticamente
        $this->email = $email;
        $this->password = $password;
        
        // Valida il ruolo prima di assignarlo
        $allowedRoles = ['user', 'admin', 'moderator'];
        if (!in_array($role, $allowedRoles)) {
            throw new \Exception("Ruolo non valido: $role. Allowed: " . implode(', ', $allowedRoles));
        }
        $this->_role = $role;
    }

    /**
     * Metodo privato per validazione email usando filter_var
     */
    private function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Metodo pubblico per verificare se la password fornita è corretta
     * Nota: usiamo password_verify per confrontare la password hashata
     */
    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->_password);
    }

    /**
     * Metodo per ottenere un array con le informazioni base dell'utente
     */
    public function getInfo(): array
    {
        return [
            'email' => $this->email,
            'role' => $this->role,
        ];
    }
}