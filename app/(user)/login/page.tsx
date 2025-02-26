'use client'; // Segnala che questo è un componente client-side
import { useState } from 'react';

export default function AdminLoginPage() {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');

  const handleLogin = async () => {
    try {
      // Effettua la richiesta di accesso
      const response = await fetch('/api/admin/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password }),
      });

      if (response.ok) {
        const data = await response.json();

        // Invia il token all'endpoint per impostare il cookie
        await fetch('/api/admin/set_token', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ token: data.token }),
        });

        alert('Accesso riuscito!');
        window.location.href = '/admin/blog'; // Reindirizza alla dashboard
      } else {
        alert('Credenziali non valide');
      }
    } catch (error) {
      console.error('Errore durante l\'accesso:', error);
      alert('Si è verificato un errore. Riprova più tardi.');
    }
  };

  return (
    <div>
      <h1 className="text-4xl font-bold mb-8">Accedi come Admin</h1>
      <input
        type="email"
        placeholder="Email"
        value={email}
        onChange={(e) => setEmail(e.target.value)}
        className="w-full p-2 border rounded mb-4"
        required
      />
      <input
        type="password"
        placeholder="Password"
        value={password}
        onChange={(e) => setPassword(e.target.value)}
        className="w-full p-2 border rounded mb-4"
        required
      />
      <button onClick={handleLogin} className="bg-purple text-white px-4 py-2 w-full">
        Accedi
      </button>
    </div>
  );
}