'use client'; // Segnala che questo è un componente client-side

import Link from 'next/link';
import { useEffect } from 'react';

interface AccessDeniedProps {
  redirectPath: string;
  delay?: number; // Tempo di attesa in millisecondi (default: 5 secondi)
}

export default function AccessDenied({ redirectPath, delay = 5000 }: AccessDeniedProps) {
  useEffect(() => {
    const timer = setTimeout(() => {
      window.location.href = redirectPath; // Reindirizza automaticamente
    }, delay);

    return () => clearTimeout(timer); // Pulisci il timer se il componente viene dismontato
  }, [redirectPath, delay]);

  return (
    <div className="flex flex-col items-center justify-center min-h-screen p-4">
      <h1 className="text-4xl font-bold mb-8">Accesso Richiesto</h1>
      <p className="mb-8">
        Devi effettuare l&apos;accesso per visualizzare questa sezione. Verrai reindirizzato automaticamente alla{' '}
        <Link href={redirectPath} className="text-purple underline">
          pagina di accesso
        </Link>{' '}
        tra {delay / 1000} secondi.
      </p>
      <Link
        href={redirectPath}
        className="bg-purple text-white px-6 py-3 rounded-md hover:bg-purple-dark transition-colors"
      >
        Vai alla Pagina di Accesso
      </Link>
    </div>
  );
}