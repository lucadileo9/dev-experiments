import Module from "@molecules/Module"; // Componente per i moduli
import { Key } from "react";


// Componente AboutUs
export default async function AboutUs( ) {
  const res = await fetch('http://localhost:3000/api/pages/about-us', { next: { revalidate: 0 } });
  const datas = await res.json();
  console.log(datas);
  if (!datas) {
    return <p>Dati non disponibili</p>;
  }

  return (
    <div className="space-y-8">
      <h1 className="text-4xl font-bold text-purple mb-4">{datas.title}</h1>
      {Array.isArray(datas.modules) &&
        datas.modules.map((module: { type: string; data: unknown; }, index: Key | null | undefined) => (
          <Module key={index} type={module.type} data={module.data} />
            ))}  
    </div>
  );
}
