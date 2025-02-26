'use client';
import { useState, useEffect } from 'react';
import { useRouter } from 'next/navigation';

interface BlogFormData {
  title: string;
  content: string;
  author: string;
}

export default function AdminBlogForm({ postId }: { postId?: string }) {
  const [formData, setFormData] = useState<BlogFormData>({
    title: '',
    content: '',
    author: '',
  });

  const router = useRouter();

  useEffect(() => {
    if (postId) {
      // Se postId è presente, carica i dati dell'articolo esistente
      fetch(`/api/blog/${postId}`)
        .then((res) => res.json())
        .then((data) => setFormData(data));
    }
  }, [postId]);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();

    try {
      const method = postId ? 'PUT' : 'POST'; // Metodo PUT per aggiornare, POST per creare
      const url = postId ? `/api/blog/${postId}` : '/api/blog';

      const response = await fetch(url, {
        method,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData),
      });

      if (response.ok) {
        alert(postId ? 'Articolo aggiornato!' : 'Articolo creato!');
        router.push('/admin/blog'); // Reindirizza alla dashboard
      } else {
        alert('Errore durante il salvataggio.');
      }
    } catch (error) {
      console.error(error);
      alert('Si è verificato un errore. Riprova più tardi.');
    }
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-4">
      <input
        type="text"
        placeholder="Titolo"
        value={formData.title}
        onChange={(e) =>
          setFormData({ ...formData, title: e.target.value })
        }
        className="w-full p-2 border rounded"
        required
      />
      <textarea
        placeholder="Contenuto"
        value={formData.content}
        onChange={(e) =>
          setFormData({ ...formData, content: e.target.value })
        }
        className="w-full p-2 border rounded"
        rows={5}
        required
      ></textarea>
      <input
        type="text"
        placeholder="Autore"
        value={formData.author}
        onChange={(e) =>
          setFormData({ ...formData, author: e.target.value })
        }
        className="w-full p-2 border rounded"
        required
      />
      <button
        type="submit"
        className="bg-purple text-white px-4 py-2 w-full"
      >
        {postId ? 'Aggiorna' : 'Crea'}
      </button>
    </form>
  );
}