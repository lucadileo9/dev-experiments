// app/api/pages/[id]/route.js
import  connectDB from "@/app/utils/db";
import Page from "@/app/models/Page";
import { NextRequest, NextResponse } from "next/server";

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

    // Se l'utente non ha specificato un id, restituisci tutte le pagine
    if (id === "all") {
      console.log("Recupero di tutte le pagine");
      const pages = await Page.find();
      return new Response(JSON.stringify(pages), {
        status: 200,
        headers: { "Content-Type": "application/json" },
      });
    }

    // Recupera la pagina corrispondente all'id
    const page = await Page.findOne({ id });

    // Se la pagina non esiste, restituisci un errore 404
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

// PUT: Aggiorna i dati della pagina
// app/api/pages/[id]/route.ts
export async function PUT(request: Request, { params }: { params: { id: string } }) {
  try {
    // Connetti al database
    await connectDB();
    console.log("Connesso a MongoDB");

    // Estrai l'id della pagina dai parametri
    const { id } = params;

    // Parsa il corpo della richiesta
    const body = await request.json();
    const { modules } = body;

    // Verifica che i moduli siano un array
    if (!Array.isArray(modules)) {
      return new Response(
        JSON.stringify({ message: "I moduli devono essere un array" }),
        {
          status: 400,
          headers: { "Content-Type": "application/json" },
        }
      );
    }

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

    // Aggiorna i moduli della pagina
    page.modules = modules.map((module: any) => { // Itero attraverso i moduli passati nella richiesta
      const existingModule = page.modules.find( // Cerco un modulo esistente (nel DB) con lo stesso id
        (m: any) => m._id.toString() === module._id
      );
      return existingModule ? // Trovato?
       { ...existingModule, ...module }  // sì, allora ne mantengo le proprietà e sovrascrivo quelle nuove (...module)
       : module; // no, allora lo aggiungo. In realta questo caso non dovrebbe mai verificarsi
    });

    // Salva le modifiche nel database
    await page.save();

    // Restituisci una risposta di successo
    return new Response(
      JSON.stringify({ message: "Modifiche salvate con successo" }),
      {
        status: 200,
        headers: { "Content-Type": "application/json" },
      }
    );
  } catch (error) {
    console.error("Errore durante l'aggiornamento della pagina:", error);
    return new Response(
      JSON.stringify({ message: "Errore interno del server" }),
      {
        status: 500,
        headers: { "Content-Type": "application/json" },
      }
    );
  }
}