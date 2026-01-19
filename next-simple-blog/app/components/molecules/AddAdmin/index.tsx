'use client'; // Segnala che questo è un componente client-side

import { useState } from 'react';

export default function AddAdminPageContent() {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');

  const handleAddAdmin = async () => {
    try {
      const response = await fetch('/api/admin/register', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password }),
        credentials: 'include', // Include i cookie nella richiesta
      });

      if (response.ok) {
        alert('Nuovo admin creato con successo!');
        setEmail('');
        setPassword('');
      } else {
        alert('Errore durante la registrazione dell\'admin.');
      }
    } catch (error) {
      console.error(error);
      alert('Si è verificato un errore. Riprova più tardi.');
    }
  };

  return (
    <div>
      <h1 className="text-4xl font-bold mb-8">Aggiungi Nuovo Admin</h1>
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
      <button onClick={handleAddAdmin} className="bg-purple text-white px-4 py-2 w-full">
        Aggiungi Admin
      </button>
    </div>
  );
}