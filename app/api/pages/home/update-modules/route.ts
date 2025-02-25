// app/api/pages/[id]/update-modules/route.js
import connectDB from "@/app/utils/db";
import Page from "@/app/models/Page";

interface Params {
  params: {
    id: string; // ID della pagina (es. 'home')
  };
}

export async function PUT(request: Request, { params }: Params) {
  try {
    await connectDB();

    const { id } = params;
    const body = await request.json();

    // Estrai i dati dal corpo della richiesta
    const { modules } = body;

    if (!Array.isArray(modules)) {
      return new Response(
        JSON.stringify({ message: "Dati non validi" }),
        { status: 400, headers: { "Content-Type": "application/json" } }
      );
    }

    // Trova la pagina
    const page = await Page.findOne({ id });
    if (!page) {
      return new Response(
        JSON.stringify({ message: "Pagina non trovata" }),
        { status: 404, headers: { "Content-Type": "application/json" } }
      );
    }

    // Aggiorna i moduli
    page.modules = modules;
    await page.save();

    return new Response(
      JSON.stringify({ message: "Moduli aggiornati con successo", page }),
      { status: 200, headers: { "Content-Type": "application/json" } }
    );
  } catch (error) {
    console.error("Errore durante l'aggiornamento dei moduli:", error);
    return new Response(
      JSON.stringify({ message: "Errore interno del server" }),
      { status: 500, headers: { "Content-Type": "application/json" } }
    );
  }
}