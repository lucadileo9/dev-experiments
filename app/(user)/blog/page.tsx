import Link from 'next/link';

export default async function BlogPage() {
  const res = await fetch('http://localhost:3000/api/blog/', { next: { revalidate: 60 } });
  const posts = await res.json();
console.log(posts);

// Se la lista di post è vuota o non disponibile, restituisci un messaggio di errore
if (posts.length === 0) {
    return <p>Non ci sono post disponibili</p>;
    }


return (
    <div>
      <h1 className="text-4xl font-bold mb-8">Blog</h1>
      <ul>
        {posts.map((post: any) => (
          <li key={post._id} className="mb-4">
            <Link href={`/blog/${post._id}`} className="text-xl text-purple hover:underline">
              {post.title}
            </Link>
            <p>{post.author}</p>
          </li>
        ))}
      </ul>
    </div>
  );
}