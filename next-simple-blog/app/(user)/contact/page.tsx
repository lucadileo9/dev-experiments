import Module from "@molecules/Module";
import { Key } from "react";

export default async function AboutUs() {
  // Fetch i dati dalla route API
  const res = await fetch("http://localhost:3000/api/pages/contact", {
    next: { revalidate: 60 }, // Cache per 60 secondi (ISR)
  });

  if (!res.ok) {
    throw new Error("Failed to fetch data");
  }

  const page = await res.json(); // Dati restituiti dall'API

  return (
    <div className="space-y-8">
      <h1 className="text-4xl font-bold text-purple mb-4">{page.title}</h1>
      {Array.isArray(page.modules) &&
        page.modules.map((module: { type: string; data: unknown; }, index: Key | null | undefined) => (
          <Module key={index} type={module.type} data={module.data} />
            ))}  

    </div>
  );
}