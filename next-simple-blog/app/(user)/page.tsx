'use client';
import Module from "@molecules/Module";
import { ReactElement, useEffect, useState } from "react";

export default function Home(): ReactElement {

  const [pages, setPages] = useState<{ title: string; modules: any[] } | null>(null);

  // Effettua una richiesta GET all'API Route per recuperare gli utenti
  useEffect(() => {
    fetch('api/pages/home') // Chiamata all'endpoint /api/users
      .then((res) => res.json())
      .then((data) => setPages(data));
  }, []);

  if (!pages || !pages.modules) {
    return <p>Dati non disponibili</p>;
  }

  return ( 
      <div className="space-y-8">
      <h1 className="text-4xl font-bold text-purple mb-4">{pages?.title}</h1>
      {Array.isArray(pages?.modules) &&
        pages.modules.map((module, index) => (
          <Module key={index} type={module.type} data={module.data} />
            ))}  
      </div>
  )
}
