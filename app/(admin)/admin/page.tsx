// app/about-us/edit.tsx
"use client";

import { useState, useEffect } from "react";
import axios from "axios";

export default function EditAboutUs() {
  const [modules, setModules] = useState([]);
  const [editedModules, setEditedModules] = useState({});

  // Fetch dei moduli al caricamento
  useEffect(() => {
    async function fetchModules() {
      try {
        const res = await axios.get("/api/pages/about-us");
        setModules(res.data.modules);
      } catch (error) {
        console.error("Errore durante il caricamento dei moduli:", error);
      }
    }
    fetchModules();
  }, []);

  // Gestione della modifica dei dati di un modulo
  const handleInputChange = (moduleId: string, field: string, value: any) => {
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

      await axios.put("/api/pages/about-us", { modules: updatedModules });
      alert("Modifiche salvate con successo!");
    } catch (error) {
      console.error("Errore durante il salvataggio:", error);
      alert("Si è verificato un errore durante il salvataggio.");
    }
  };

  return (
    <div>
      <h1>Modifica Pagina About Us</h1>

      {/* Form per ogni modulo */}
      {modules.map((module) => (
        <div key={module._id}>
          <h2>{module.type}</h2>
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
  );
}