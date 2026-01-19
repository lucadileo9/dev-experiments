export default async function BlogPostPage({ params }: { params: { id: string } }) {
    const res = await fetch(`http://localhost:3000/api/blog/${params.id}`, { next: { revalidate: 60 } });
    const post = await res.json();
  
    if (!post) return <p>Articolo non trovato</p>;
  
    return (
      <div>
        <h1 className="text-4xl font-bold mb-8">{post.title}</h1>
        <p><strong>Autore:</strong> {post.author}</p>
        <div dangerouslySetInnerHTML={{ __html: post.content }}></div>
      </div>
    );
  }