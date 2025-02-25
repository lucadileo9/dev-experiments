// app/admin/page.tsx
"use client";

import { useState, useEffect } from "react";
import axios from "axios";

export default function Admin() {
  const [pages, setPages] = useState([]);
  const [selectedPageId, setSelectedPageId] = useState(null);
  const [modules, setModules] = useState([]);
  const [editedModules, setEditedModules] = useState({});

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
  const handlePageSelect = async (pageId) => {
    try {
      const res = await axios.get(`/api/pages/${pageId}`);
      setSelectedPageId(pageId);
      setModules(res.data.modules);
    } catch (error) {
      console.error("Errore durante il caricamento dei moduli:", error);
    }
  };

  // Gestione della modifica dei dati di un modulo
  const handleInputChange = (moduleId, field, value) => {
    setEditedModules((prev) => ({
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
    <div>
      <h1>Amministrazione</h1>

      {/* Lista delle pagine */}
      <h2>Pagine:</h2>
      <ul>
        {pages.map((page) => (
          <li key={page.id} onClick={() => handlePageSelect(page.id)}>
            {page.title}
          </li>
        ))}
      </ul>

      {/* Form per modificare i moduli della pagina selezionata */}
      {selectedPageId && (
        <div>
          <h3>Modifica Pagina: {pages.find((p) => p.id === selectedPageId)?.title}</h3>
          {modules.map((module) => (
            <div key={module._id}>
              <h4>{module.type}</h4>
              {Object.keys(module.data).map((field) => (
                <div key={field}>
                  <label>{field}:</label>
                  <input
                    type="text"
                    value={editedModules[module._id]?.data?.[field] || module.data[field]}
                    onChange={(e) =>
                      handleInputChange(module._id, field, e.target.value)
                    }
                  />
                </div>
              ))}
            </div>
          ))}

          {/* Bottone per salvare */}
          <button onClick={handleSave}>Salva Modifiche</button>
        </div>
      )}
    </div>
  );
}