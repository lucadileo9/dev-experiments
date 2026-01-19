import connectDB from "@/app/utils/db";
import BlogPost from "@/app/models/BlogPost";

export const GET = async (request: Request, { params }: { params: { id?: string } }) => {
  await connectDB(); // Connetti al database

    const post = await BlogPost.findById(params.id);
    if (!post) 
    {
        console.log("Articolo non trovato");
        return new Response('Articolo non trovato', { status: 404 });
    }
    return Response.json(post);
  
};

export const PUT = async (request: Request, { params }: { params: { id: string } }) => {
    await connectDB(); // Connetti al database
  
    const body = await request.json();
    const { title, content, author } = body;
  
    const updatedPost = await BlogPost.findByIdAndUpdate(
      params.id,
      { title, content, author },
      { new: true }
    );
  
    if (!updatedPost) return new Response('Articolo non trovato', { status: 404 });
  
    return Response.json(updatedPost);
  };


export const DELETE = async (request: Request, { params }: { params: { id: string } }) => {
    await connectDB(); // Connetti al database
  
    const deletedPost = await BlogPost.findByIdAndDelete(params.id);
  
    if (!deletedPost) return new Response('Articolo non trovato', { status: 404 });
  
    return Response.json(deletedPost);
  };