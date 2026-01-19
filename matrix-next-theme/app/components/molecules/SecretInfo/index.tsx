import React, { FC } from "react";
import SecretInfoProps from "./index.types"
import TypewriterEffect from "@molecules/TypewriterEffect";
import { ArrowLeft, Lock, Eye, EyeOff } from "lucide-react"

const SecretInfo: FC<SecretInfoProps> = ({ }) => {
  const secretInfo = [
    "La Matrix è un programma di simulazione neurale interattiva.",
    "Zion è l'ultima città umana, situata vicino al nucleo della Terra.",
    "Gli Agenti sono programmi di sicurezza con la capacità di possedere qualsiasi persona ancora connessa alla Matrix.",
    "La profezia dell'Eletto è stata creata dal programma Oracle per controllare le anomalie del sistema.",
    "Il codice sorgente della Matrix è accessibile solo dall'Architetto e dall'Oracolo.",
  ]
  return <>
  <div className="border border-[#00FF41]/30 bg-black/50 p-6 mb-8">
            <div className="flex items-center mb-4">
              <Lock className="h-6 w-6 mr-2" />
              <h2 className="text-2xl font-bold">
                <TypewriterEffect text="Accesso Risevato" delay={20} startDelay={3000} />
              </h2>
            </div>
            <p className="mb-4">
              <TypewriterEffect
                text="Le seguenti informazioni sono classificate al massimo livello di segretezza. La divulgazione non autorizzata è punibile con la disconnessione permanente."
                delay={20}
                startDelay={4000}
              />
            </p>
            <div className="space-y-4">
              {secretInfo.map((info, index) => (
                <div key={index} className="flex items-start">
                  <div className="mr-4 flex-shrink-0 h-6 w-6 flex items-center justify-center border border-[#00FF41]">
                    <span className="digital-code text-sm">{index + 1}</span>
                  </div>
                  <p>
                    <TypewriterEffect text={info} delay={100} startDelay={8000} />
                  </p>
                </div>
              ))}
            </div>
          </div></>
}

export default SecretInfo