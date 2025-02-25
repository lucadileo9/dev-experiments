// app/api/pages/[id]/modules/[moduleId]/route.js
import connectDB from "@/app/utils/db";
import Page from "@/app/models/Page";

interface Params {
  params: {
    id: string; // ID della pagina (es. 'home')
    moduleId: string; // ID del modulo da modificare
  };
}

export async function PUT(request: Request, { params }: Params) {
  try {
    await connectDB();

    const { id, moduleId } = params;
    const body = await request.json();

    // Estrai i dati dal corpo della richiesta
    const { data } = body;

    if (!data || typeof data !== "object") {
      return new Response(
        JSON.stringify({ message: "Dati non validi" }),
        { status: 400, headers: { "Content-Type": "application/json" } }
      );
    }

    // Trova la pagina e aggiorna il modulo specifico
    const page = await Page.findOne({ id });
    if (!page) {
      return new Response(
        JSON.stringify({ message: "Pagina non trovata" }),
        { status: 404, headers: { "Content-Type": "application/json" } }
      );
    }

    // Trova il modulo da aggiornare
    const moduleIndex = page.modules.findIndex((m: { _id: string; }) => m._id == moduleId);
    if (moduleIndex === -1) {
      return new Response(
        JSON.stringify({ message: "Modulo non trovato" }),
        { status: 404, headers: { "Content-Type": "application/json" } }
      );
    }

    // Aggiorna solo il campo `data` del modulo
    page.modules[moduleIndex].data = data;
    await page.save();

    return new Response(
      JSON.stringify({ message: "Modulo aggiornato con successo", page }),
      { status: 200, headers: { "Content-Type": "application/json" } }
    );
  } catch (error) {
    console.error("Errore durante l'aggiornamento del modulo:", error);
    return new Response(
      JSON.stringify({ message: "Errore interno del server" }),
      { status: 500, headers: { "Content-Type": "application/json" } }
    );
  }
}