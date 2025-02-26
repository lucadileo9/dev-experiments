'use client';
import Link from 'next/link';

export default async function AdminBlogPage() {
  const res = await fetch('http://localhost:3000/api/blog', { next: { revalidate: 60 } });
  const posts = await res.json();

  return (
    <div>
      <h1 className="text-4xl font-bold mb-8">Gestione Articoli</h1>

      {/* Bottone per aggiungere un nuovo articolo */}
      <Link href="/admin/blog/new" className="bg-purple text-white px-4 py-2 mb-8">
        Aggiungi Articolo
      </Link>

      {/* Elenco degli articoli */}
      <ul>
        {posts.map((post: any) => (
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

  // Funzione per eliminare un articolo
  async function handleDelete(id: string) {
    if (!confirm('Sei sicuro di voler eliminare questo articolo?')) return;

    try {
      const response = await fetch(`/api/blog/${id}`, {
        method: 'DELETE',
      });

      if (response.ok) {
        alert('Articolo eliminato con successo!');
        window.location.reload(); // Aggiorna la pagina
      } else {
        alert('Errore durante l\'eliminazione dell\'articolo.');
      }
    } catch (error) {
      console.error(error);
      alert('Si è verificato un errore. Riprova più tardi.');
    }
  }
}