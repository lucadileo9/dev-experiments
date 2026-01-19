import React, { FC, useEffect, useState } from "react";
import TypewriterEffectProps from "./index.types"

const TypewriterEffect: FC<TypewriterEffectProps> = ({ 
  text,
  delay = 100,
  startDelay = 0,}) => {
  const [displayText, setDisplayText] = useState("") // Testo visualizzato finora
  const [currentIndex, setCurrentIndex] = useState(0) // Indice della lettera corrente
  const [started, setStarted] = useState(false) // Flag per indicare se l'effetto è iniziato
  
  /*
  Funzione che gestisce qunado l'effetto inizia
  praticamente setta il flag started a true dopo il tempo di startDelay
  */
  useEffect(() => {
    const initialTimer = setTimeout(() => {
      setStarted(true);
    }, startDelay);

    return () => clearTimeout(initialTimer); // Pulizia del timer
  }, [startDelay]);

  /*
  Funzione che gestisce l'effetto di scrittura
  */
  useEffect(() => {
    if (!started) return; // Se l'effetto non è iniziato non fare nulla

    if (currentIndex < text.length) { // Se non ho finito di scrivere il testo

      const timer = setTimeout(() => { // Setto un timer per scrivere la lettera corrente
        setDisplayText((prev) => prev + text[currentIndex]); // Aggiungo la lettera corrente al testo visualizzato
        setCurrentIndex((prev) => prev + 1); // Incremento l'indice della lettera corrente
        
      }, delay); // Delay tra una lettera e l'altra

      return () => clearTimeout(timer);
    }
  }, [currentIndex, delay, started, text]); // La dipendenza da started è necessaria per evitare che l'effetto non venga eseguito
  // la dipendenza da currentIndex è necessaria per evitare che l'effetto venga eseguito solo per il primo carattere
  // delay e text non mi sembrano essenziali, ma vabbe

  return (
    <span>
      {displayText}
      <span className="animate-pulse">|</span>
    </span>
  );
}

export default TypewriterEffect;
