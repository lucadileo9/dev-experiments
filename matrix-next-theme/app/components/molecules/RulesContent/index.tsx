import React, { FC, useState } from "react";
import RulesContentProps from "./index.types"
import { Eye, Shield, Zap, Code, AlertTriangle } from "lucide-react";

const RulesContent: FC<RulesContentProps> = ({ showContent}) => {
  const [activeSection, setActiveSection] = useState("access") // Serve per tenere traccia della sezione attiva

  const rules = {
    access: [
      "Solo gli individui selezionati possono accedere alla verità della Matrix.",
      "La pillola rossa è l'unico modo per uscire dalla simulazione.",
      "Una volta fuori, non è possibile tornare indietro alla vita precedente.",
      "La conoscenza della Matrix comporta responsabilità e pericoli.",
    ],
    security: [
      "Mai rivelare la posizione della Nabucodonosor a nessuno.",
      "Le comunicazioni devono essere effettuate solo attraverso linee sicure.",
      "Gli Agenti possono assumere l'identità di qualsiasi persona ancora collegata.",
      "Evitare il contatto con i programmi senziente non alleati.",
    ],
    combat: [
      "Ricorda, nella Matrix le regole fisiche possono essere piegate, non infrante.",
      "La mente deve essere libera per superare i limiti imposti dalla simulazione.",
      "Evita lo scontro diretto con gli Agenti quando possibile.",
      "La fuga è spesso la strategia migliore contro forze superiori.",
    ],
    hacking: [
      "L'Operatore è l'unico autorizzato a caricare programmi durante le missioni.",
      "I punti di ingresso e uscita devono essere stabiliti prima di ogni missione.",
      "I telefoni fissi sono l'unico mezzo sicuro per uscire dalla Matrix.",
      "Ogni modifica al codice della Matrix lascia tracce che possono essere rilevate.",
    ],
    survival: [
      "La morte nella Matrix significa morte nel mondo reale.",
      "Mantieni sempre la consapevolezza della tua vera natura durante la connessione.",
      "Non fidarti di ciò che vedi; la Matrix è progettata per ingannare i sensi.",
      "Solo l'Eletto può sfidare direttamente il sistema e sopravvivere.",
    ],
  }

  // associa ad ogni sezione un'icona specifica
  const ruleIcons = {
    access: <Eye className="h-6 w-6" />,
    security: <Shield className="h-6 w-6" />,
    combat: <Zap className="h-6 w-6" />,
    hacking: <Code className="h-6 w-6" />,
    survival: <AlertTriangle className="h-6 w-6" />,
  }

  const ruleTitles = {
    access: "Regole di Accesso",
    security: "Protocolli di Sicurezza",
    combat: "Tattiche di Combattimento",
    hacking: "Procedure di Hacking",
    survival: "Linee Guida di Sopravvivenza",
  }
  return <>
  <section className="container mx-auto px-4 py-8">
            <div className={`transition-opacity duration-1000 ${showContent ? "opacity-100" : "opacity-0"}`}>
              <div className="grid md:grid-cols-5 gap-6">

                {/* Sidebar Navigation */}
                <div className="md:col-span-1 space-y-2">
                  {/* restituisce un array con i nomi delle chiavi dell'oggetto rules, così da mappare ogni nome in un pulsante*/}
                  {Object.keys(rules).map((section) => (
                    <button
                      key={section}
                      onClick={() => setActiveSection(section)} // Cambia la sezione attiva al click
                      className={`w-full text-left p-4 border transition-colors duration-300 flex items-center ${
                        activeSection === section // Cambia lo stile del pulsante attivo
                          ? "border-[#00FF41] bg-[#001a00]"
                          : "border-[#00FF41]/30 hover:bg-[#001a00]/50"
                      }`}
                    >
                      {/* L'icona associata alla sezione viene estratta dall'oggetto ruleIcons */}
                      <span className="mr-3">{ruleIcons[section as keyof typeof ruleIcons]}</span> 
                      {/* Il titolo della sezione viene estratto dall'oggetto ruleTitles */}
                      <span>{ruleTitles[section as keyof typeof ruleTitles]}</span>
                    </button>
                  ))}
                </div>

                {/* Rules Display */}
                <div className="md:col-span-4 border border-[#00FF41]/30 bg-black/50 p-6">
                  <div className="border-b border-[#00FF41]/30 pb-4 mb-6">
                    <div className="flex items-center">
                      {/* Gli oggetti vengono messi in una riga, grazie alla classe flex */}

                      {/* L'icona associata alla sezione viene estratta dall'oggetto ruleIcons */}
                      {ruleIcons[activeSection as keyof typeof ruleIcons]} 

                      <h2 className="text-2xl font-bold ml-3">
                      {/* Il titolo della sezione viene estratto dall'oggetto ruleTitles */}
                        {ruleTitles[activeSection as keyof typeof ruleTitles]}
                      </h2>

                    </div>

                    <p className="mt-2 text-[#00FF41]/70">

                      {activeSection === "access" &&
                        "Linee guida per l'accesso alla verità e alla realtà al di fuori della Matrix."}
                      {activeSection === "security" &&
                        "Protocolli essenziali per mantenere la sicurezza dell'equipaggio e della nave."}
                      {activeSection === "combat" &&
                        "Strategie e tattiche per affrontare gli Agenti e altre minacce nella Matrix."}
                      {activeSection === "hacking" &&
                        "Procedure tecniche per manipolare e navigare all'interno del sistema della Matrix."}
                      {activeSection === "survival" &&
                        "Principi fondamentali per sopravvivere sia nella Matrix che nel mondo reale."}
                    </p>
                  </div>

                  <div className="space-y-6">
                    {rules[activeSection as keyof typeof rules].map((rule, index) => ( // Estrae le regole dalla sezione attiva
                    
                      <div key={index} className="flex">
                        <div className="mr-4 flex-shrink-0 h-10 w-10 flex items-center justify-center border border-[#00FF41]">
                          <span className="digital-code text-sm">{index + 1}</span>
                        </div>
                        <div>
                          <p className="text-lg">{rule}</p>
                        </div>
                      </div>
                    ))}
                  </div>

                  <div className="mt-8 p-4 border border-[#00FF41]/30 bg-[#001a00]/30">
                    <p className="text-sm text-[#00FF41]/70 italic">
                      &quot;Ricorda: la Matrix è ovunque, è intorno a noi. Anche adesso, nella stanza in cui ti trovi. È
                      quello che vedi quando ti affacci alla finestra, o quando accendi il televisore. La avverti quando
                      vai al lavoro, quando vai in chiesa, quando paghi le tasse.&quot;
                    </p>
                    <p className="text-right mt-2 text-sm">— Morpheus</p>
                  </div>
                </div>
              </div>
            </div>
          </section>
          </>
}

export default RulesContent