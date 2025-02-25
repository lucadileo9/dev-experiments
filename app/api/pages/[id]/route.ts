// app/api/pages/[id]/route.js
import  connectDB from "@/app/utils/db";
import Page from "@/app/models/Page";

interface Params {
  params: {
    id: string; // L'id della pagina
  };
}

export async function GET(request: Request, { params }: Params) {
  try {
    // Connetti al database
    await connectDB();
    console.log("Connesso a MongoDB");

    // Estrai l'id della pagina dai parametri
    const { id } = params;

    // Recupera la pagina corrispondente all'id
    const page = await Page.findOne({ id });

    if (!page) {
      console.log(`Pagina con ID '${id}' non trovata`);
      return new Response(
        JSON.stringify({ message: "Pagina non trovata" }),
        {
          status: 404,
          headers: { "Content-Type": "application/json" },
        }
      );
    }

    // Restituisci i dati della pagina in formato JSON
    return new Response(JSON.stringify(page), {
      status: 200,
      headers: { "Content-Type": "application/json" },
    });
  } catch (error) {
    console.error("Errore durante il recupero della pagina:", error);
    return new Response(
      JSON.stringify({ message: "Errore interno del server" }),
      {
        status: 500,
        headers: { "Content-Type": "application/json" },
      }
    );
  }
}