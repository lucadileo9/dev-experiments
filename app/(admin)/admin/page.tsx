// app/admin/page.tsx
"use client";

import { useState, useEffect, SetStateAction, ReactNode } from "react";
import axios from "axios";

interface Module {
  type: ReactNode;
  _id: any;
  data: { [key: string]: string }; // Un oggetto con chiavi stringhe e valori stringhe
}

type EditedModules = {
  [key: string | number]: Module; // Un oggetto con chiavi stringhe o numeri e valori di tipo Module
};

interface Page {
  id: string;
  title: string;
  modules: Module[];
}

export default function Admin() {
  const [pages, setPages] = useState<Page[]>([]);
  const [selectedPageId, setSelectedPageId] = useState("");
  const [modules, setModules] = useState<Module[]>([]);
  const [editedModules, setEditedModules] = useState<EditedModules>({});

  // Fetch delle pagine al caricamento
  useEffect(() => {
    async function fetchPages() {
      try {
        const res = await axios.get("/api/pages/all");
        console.log(res.data);
        setPages(res.data);
      } catch (error) {
        console.error("Errore durante il caricamento delle pagine:", error);
      }
    }
    fetchPages();
  }, []);

  // Seleziona una pagina per visualizzare/modificare i moduli
  const handlePageSelect = async (pageId: string) => {
    try {
      const res = await axios.get(`/api/pages/${pageId}`);
      setSelectedPageId(pageId);
      setModules(res.data.modules);
    } catch (error) {
      console.error("Errore durante il caricamento dei moduli:", error);
    }
  };

  // Gestione della modifica dei dati di un modulo
  const handleInputChange = (moduleId: string | number, field: string, value: string) => {
    setEditedModules((prev: EditedModules) => ({
      ...prev,
      [moduleId]: {
        ...(prev[moduleId] || {}),
        data: {
          ...(prev[moduleId]?.data || {}),
          [field]: value,
        },
      },
    }));
  };

  // Salva le modifiche
  const handleSave = async () => {
    try {
      const updatedModules = modules.map((module) => {
        const editedModule = editedModules[module._id];
        return editedModule ? { ...module, ...editedModule } : module;
      });

      await axios.put(`/api/pages/${selectedPageId}`, { modules: updatedModules });
      alert("Modifiche salvate con successo!");
    } catch (error) {
      console.error("Errore durante il salvataggio:", error);
      alert("Si è verificato un errore durante il salvataggio.");
    }
  };

  return (
    <div className="min-h-screen bg-beige text-purple-900 p-4">
    <h1 className="text-3xl font-bold mb-6">Amministrazione</h1>
  
    {/* Lista delle pagine */}
    <div className="mb-8">
      <h2 className="text-2xl font-semibold mb-2">Pagine:</h2>
      <ul className="list-disc pl-6 space-y-2">
        {pages.map((page) => (
          <li
            key={page.id}
            onClick={() => handlePageSelect(page.id)}
            className="cursor-pointer hover:text-purple-700 transition-colors"
          >
            {page.title}
          </li>
        ))}
      </ul>
    </div>
  
    {/* Form per modificare i moduli della pagina selezionata */}
    {selectedPageId && (
      <div className="bg-white shadow-md rounded-lg p-6 max-w-3xl mx-auto">
        <h3 className="text-xl font-semibold mb-4">
          Modifica Pagina:{" "}
          {pages.find((p) => p.id === selectedPageId)?.title || "Pagina non trovata"}
        </h3>
  
        {modules.map((module) => (
          <div key={module._id} className="mb-6">
            <h4 className="text-lg font-medium mb-2">{module.type}</h4>
            {Object.keys(module.data).map((field) => (
              <div key={field} className="flex items-center mb-2">
                <label
                  htmlFor={field}
                  className="block w-32 text-sm font-medium text-gray-700 mr-2"
                >
                  {field}:
                </label>
                <input
                  type="text"
                  id={field}
                  value={editedModules[module._id]?.data?.[field] || module.data[field]}
                  onChange={(e) =>
                    handleInputChange(module._id, field, e.target.value)
                  }
                  className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                />
              </div>
            ))}
          </div>
        ))}
  
        {/* Bottone per salvare */}
        <button
          onClick={handleSave}
          className="w-full bg-purple-600 text-white font-semibold py-2 px-4 rounded-md hover:bg-purple-700 transition-colors"
        >
          Salva Modifiche
        </button>
      </div>
    )}
  </div>
  );
}