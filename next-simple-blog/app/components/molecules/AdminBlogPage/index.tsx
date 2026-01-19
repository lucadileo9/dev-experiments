'use client'; // Segnala che questo è un componente client-side

import { useState, useEffect } from 'react';
import Link from 'next/link';

export default function AdminBlogPageContent() {
  const [posts, setPosts] = useState<any[]>([]);

  useEffect(() => {
    // Fetch dei post quando il componente viene montato
    fetch('http://localhost:3000/api/blog')
      .then((res) => res.json())
      .then((data) => setPosts(data))
      .catch((error) => console.error('Errore durante il caricamento dei post:', error));
  }, []);

  // Funzione per eliminare un articolo
  const handleDelete = async (id: string) => {
    if (!confirm('Sei sicuro di voler eliminare questo articolo?')) return;

    try {
      const response = await fetch(`/api/blog/${id}`, {
        method: 'DELETE',
      });

      if (response.ok) {
        alert('Articolo eliminato con successo!');
        setPosts((prevPosts) => prevPosts.filter((post) => post._id !== id)); // Aggiorna lo stato
      } else {
        alert('Errore durante l\'eliminazione dell\'articolo.');
      }
    } catch (error) {
      console.error(error);
      alert('Si è verificato un errore. Riprova più tardi.');
    }
  };

  return (
    <div>
      <h1 className="text-4xl font-bold mb-8">Gestione Articoli</h1>

      {/* Bottone per aggiungere un nuovo articolo */}
      <Link href="/admin/blog/new" className="bg-purple text-white px-4 py-2 mb-8">
        Aggiungi Articolo
      </Link>

      {/* Elenco degli articoli */}
      <ul>
        {posts.map((post) => (
          <li key={post._id} className="mb-4 flex items-center justify-between">
            <div>
              <h2>{post.title}</h2>
              <p><strong>Autori:</strong> {post.author}</p>
            </div>
            <div className="space-x-2">
              {/* Pulsante Modifica */}
              <Link
                href={`/admin/blog/edit/${post._id}`}
                className="bg-blue-500 text-white px-4 py-2"
              >
                Modifica
              </Link>
              {/* Pulsante Elimina */}
              <button
                onClick={() => handleDelete(post._id)}
                className="bg-red-500 text-white px-4 py-2"
              >
                Elimina
              </button>
            </div>
          </li>
        ))}
      </ul>
    </div>
  );
}