// app/admin/page.tsx
"use client";

import { useState, useEffect, SetStateAction, ReactNode } from "react";
import axios from "axios";

/**
 * Represents a module with a specific type, unique identifier, and associated data.
 * 
 * @interface Module
 * 
 * @property {ReactNode} type - The type of the module, represented as a ReactNode (e.g., a component, like Hero, Location...).
 * @property {any} _id - The unique identifier for the module.
 * @property {Object.<string, string>} data - A dictionary containing key-value pairs of data associated with the module.
 */
interface Module {
  type: ReactNode;
  _id: any;
  data: { [key: string]: string }; 
}

/**
 * Represents a collection of modules that have been edited.
 * The keys can be either strings or numbers, and each key maps to a `Module` (that is the module being edited).
 */
type EditedModules = {
  [key: string | number]: Module; 
};

/**
 * Represents a page in the admin section of the application.
 * 
 * @interface Page
 * @property {string} id - The unique identifier for the page.
 * @property {string} title - The title of the page.
 * @property {Module[]} modules - An array of modules associated with the page.
 */
interface Page {
  id: string;
  title: string;
  modules: Module[];
}

export default function Admin() {
  const [pages, setPages] = useState<Page[]>([]); // Array di tutte le pagine disponibili nel sito
  const [selectedPageId, setSelectedPageId] = useState(""); // ID della pagina selezionata dall'utente per la modifica
  const [modules, setModules] = useState<Module[]>([]); // Array di moduli associati alla pagina selezionata
  const [editedModules, setEditedModules] = useState<EditedModules>({}); // Oggetto che tiene traccia delle modifiche apportate ai moduli


  useEffect(() => {
    /**
     * Fetches all pages from the API and updates the state with the retrieved data.
     * 
     * This function makes an asynchronous GET request to the `/api/pages/all` endpoint
     * to retrieve all pages. Upon successful retrieval, it logs the data to the console
     * and updates the state with the fetched pages. If an error occurs during the request,
     * it logs an error message to the console.
     * 
     * @async
     * @function fetchPages
     * @returns {Promise<void>} A promise that resolves when the pages have been fetched and the state has been updated.
     */
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

  /**
   * Handles the selection of a page by fetching its details and updating the state.
   *
   * @param {string} pageId - The ID of the page to be selected.
   * @returns {Promise<void>} A promise that resolves when the page details have been fetched and the state has been updated.
   *
   * @throws Will log an error message to the console if the request fails.
   */
  const handlePageSelect = async (pageId: string) => {
    try {
      const res = await axios.get(`/api/pages/${pageId}`); // Effettua una richiesta GET per ottenere i dettagli della pagina selezionata.
      setSelectedPageId(pageId); // Specifichiamo l'ID della pagina selezionata.
      setModules(res.data.modules); // Aggiorniamo lo stato `modules` con i moduli associati alla pagina.
    } catch (error) {
      console.error("Errore durante il caricamento dei moduli:", error);
    }
  };

  /**
   * Handles the change of input fields for a specific module.
   *
   * @param {string | number} moduleId - The unique identifier of the module.
   * @param {string} field - The name of the field being updated  (es. "title", "subtitle").
   * @param {string} value - The new value for the specified field.
   *
   * @returns {void}
   */
  const handleInputChange = (moduleId: string | number, field: string, value: string) => {
    // Aggiorna lo stato `editedModules` mantenendo invariati i dati non modificati.
    setEditedModules((prev: EditedModules) => ({ // prev rappresenta lo stato CORRENTE di editedModules
      ...prev, // Copia tutti i moduli esistenti in `editedModules`.
      [moduleId]: { // Aggiorniamo il modulo con l'ID specificato.
        ...(prev[moduleId] || {}), // Mantenendo i dati esistenti del modulo //// se esiste, altrimenti crea un oggetto vuoto. QUesto serve solo per evitare errori
        data: { // E aggiornando solo i dati del modulo.
          ...(prev[moduleId]?.data || {}), // Copiamo i dati esistenti del modulo  //// se presenti, altrimenti crea un oggetto vuoto. Questo serve solo per evitare errori
          [field]: value, // Infine sovrascriviamo il campo specificato con il nuovo valore.
        },
      },
    }));
  }
  
  /**
   * Handles the save operation for updating modules.
   * 
   * This function maps through the existing modules and updates them with any 
   * edited data. It then sends a PUT request to update the page with the new 
   * module data. If the operation is successful, a success alert is shown. 
   * If an error occurs, it logs the error to the console and shows an error alert.
   * 
   * @async
   * @function handleSave
   * @returns {Promise<void>} A promise that resolves when the save operation is complete.
   * @throws Will throw an error if the save operation fails.
   */
  const handleSave = async () => {
  // Creiamo l'array updatedModules che contiene i moduli aggiornati. 
  // L'array viene creato mappando i moduli originali e applicando una trasformazione a ciascun elemento, con una funzione di callback scritta come arrow function.
    try {
      const updatedModules = modules.map((module) => {   // Quindi iteriamo su tutti i moduli originali e, per ciascuno di essi,
        const editedModule = editedModules[module._id];   //  controlliamo se esiste un modulo corrispondente in editedModules.
        return editedModule ?  // esiste ?
        { ...module, ...editedModule }  // sì, combiniamo il modulo originale con le modifiche
        : module; //  no, lasciamo il modulo originale invariato
      });

      // Effettuiamo una richiesta PUT per aggiornare i moduli della pagina selezionata
      // passando l'array updatedModules come corpo della richiesta.
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
  
        {modules.map((module) => ( // Iteriamo su tutti i moduli associati alla pagina selezionata.
          <div key={module._id} className="mb-6">
            <h4 className="text-lg font-medium mb-2">{module.type}</h4>
            {Object.keys(module.data).map((field) => ( // Qui iteriamo su tutti i campi di dati del modulo.
              // Per ciascun campo, mostriamo un campo di input per consentire all'utente di modificarlo.
              // Il valore del campo di input è impostato in base allo stato `editedModules`.
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
                  value={editedModules[module._id]?.data?.[field] || module.data[field]} // Se esiste un valore modificato, lo mostriamo, altrimenti mostriamo il valore originale.
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