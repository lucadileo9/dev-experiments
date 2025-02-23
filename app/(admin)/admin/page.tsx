'use client';
import { useState } from 'react';
import { pages } from '../../db';

export default function EditHomePage() {
  const [modules, setModules] = useState(pages.home.modules);
  type ModuleType = keyof typeof modules;

  const updateModuleData = (moduleType: ModuleType, field: string, value: string) => {
    
    setModules({
      ...modules,
      [moduleType]: {
        ...modules[moduleType],
        [field]: value,
      },
    });
  };

  return (
      <div className="min-h-screen bg-purple-100 p-8">
        <div className="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6">
          <h1 className="text-2xl font-bold text-purple-700 mb-6 text-center">Modifica Pagina Home</h1>
    
          {/* Form per il modulo Hero */}
          <div className="mb-8">
            <h2 className="text-xl font-semibold text-purple-600 mb-4">Hero</h2>
            <div className="space-y-4">
              <input
                type="text"
                placeholder="Titolo"
                value={modules.hero.title}
                onChange={(e) => updateModuleData('hero', 'title', e.target.value)}
                className="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
              />
              <input
                type="text"
                placeholder="Sottotitolo"
                value={modules.hero.subtitle}
                onChange={(e) => updateModuleData('hero', 'subtitle', e.target.value)}
                className="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
              />
              <input
                type="text"
                placeholder="Immagine"
                value={modules.hero.image}
                onChange={(e) => updateModuleData('hero', 'image', e.target.value)}
                className="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
              />
            </div>
          </div>
    
          {/* Form per il modulo Sub-Hero */}
          <div className="mb-8">
            <h2 className="text-xl font-semibold text-purple-600 mb-4">Sub-Hero</h2>
            <div className="space-y-4">
              <input
                type="text"
                placeholder="Titolo"
                value={modules['sub-hero'].title}
                onChange={(e) =>
                  updateModuleData('sub-hero', 'title', e.target.value)
                }
                className="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
              />
              <textarea
                placeholder="Contenuto"
                value={modules['sub-hero'].content}
                onChange={(e) =>
                  updateModuleData('sub-hero', 'content', e.target.value)
                }
                className="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 resize-none"
              />
            </div>
          </div>
    
          {/* Form per il modulo Location */}
          <div>
            <h2 className="text-xl font-semibold text-purple-600 mb-4">Location</h2>
            <div className="space-y-4">
              <input
                type="text"
                placeholder="Indirizzo"
                value={modules.location.address}
                onChange={(e) =>
                  updateModuleData('location', 'address', e.target.value)
                }
                className="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
              />
              <input
                type="text"
                placeholder="URL Mappa"
                value={modules.location.mapUrl}
                onChange={(e) =>
                  updateModuleData('location', 'mapUrl', e.target.value)
                }
                className="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
              />
            </div>
          </div>
        </div>
      </div>
  );
}