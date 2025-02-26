import BlogPost from "@/app/models/BlogPost";
import connectDB from "@/app/utils/db";

export const GET = async () => {
  try {
    await connectDB(); // Connetti al database
    const posts = await BlogPost.find(); // Leggi tutti gli articoli
    return Response.json(posts); // Restituisci i dati come JSON
  } catch (error) {
    console.error(error);
    return new Response('Errore interno del server', { status: 500 });
  }
};

export const POST = async (request: Request) => {
  await connectDB(); // Connetti al database

  const body = await request.json();
  const { title, content, author } = body;

  if (!title || !content || !author) {
    return new Response('Campi mancanti', { status: 400 });
  }

  const newPost = new BlogPost({ title, content, author });
  await newPost.save();

  return Response.json(newPost, { status: 201 });
};
