// components/DigitalRain.tsx
import React, { FC, useEffect, useRef } from "react";
import DigitalRainProps from "./index.types";

const DigitalRain: FC<DigitalRainProps> = ({
  fontSize = 14,
  color = "#00FF41",
  speed = 35,
  characters = "アイウエオカキクケコサシスセソタチツテトナニヌネノハヒフヘホマミムメモヤユヨラリルレロワヲン0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ",
  backgroundOpacity = 0.05, // Nuova prop per controllare la trasparenza dello sfondo

}) => {
  // Qui stiamo prendendo l'oggetto canvas nel DOM
  const canvasRef = useRef<HTMLCanvasElement>(null);

  useEffect(() => {
    const canvas = canvasRef.current; // punta all'elemento <canvas> dopo che è stato montato nel DOM
    if (!canvas) return; // controllo se canvas è effettivamente presente

    const ctx = canvas.getContext("2d"); // ottengo il contesto 2D (ctx), che permette di disegnare sul canvas
    if (!ctx) return;

    // Imposta la larghezza e l'altezza del canvas uguale alle dimensioni della finestra del browser.
    const resizeCanvas = () => {
      canvas.width = window.innerWidth;
      canvas.height = window.innerHeight;
    };

    resizeCanvas(); // chiamo la funzione per impostare le dimensioni del canvas
    // Aggiungo un gestore di evento per rilevare quando l'utente ridimensiona la finestra
    // così da chiamare la funzione resizeCanvas che aggiorna le dimensioni del canvas di conseguenza
    window.addEventListener("resize", resizeCanvas);

    // Effetto pioggia digitale
    const columns = Math.floor(canvas.width / fontSize); // calcolo il numero di colonne basandomi sulla larghezza del canvas e sulla dimensione del font

    // Array to track the y position of each column
    const drops: number[] = [];
    for (let i = 0; i < columns; i++) {
      drops[i] = Math.random() * -100; // inizializzo ogni colonna con una posizione casuale tra -100 e 0
    }

    const draw = () => {
      // Funzione per disegnare il testo sul canvas
      // Qui si cancella leggermente il frame precedente disegnando un rettangolo nero trasparente sopra l'intero canvas
      ctx.fillStyle = `rgba(0, 0, 0, ${backgroundOpacity})`; 
      ctx.fillRect(0, 0, canvas.width, canvas.height);

      ctx.fillStyle = color; // Imposta il colore del testo passato come prop (default: verde luminoso)
      ctx.font = `${fontSize}px monospace`; // Imposta il font e la dimensione del testo (fontSize, passato come prop)

      // Ciclo for che disegna un carattere casuale in ogni colonna
      for (let i = 0; i < drops.length; i++) {
        // Seleziona un carattere casuale dalla stringa characters (passata come prop)
        const text = characters.charAt(Math.floor(Math.random() * characters.length));

        // Disegno il nuovo carattere sulla colonna, così da creare l'effetto di pioggia digitale
        ctx.fillText(text, i * fontSize, drops[i] * fontSize);

        // Quando una goccia esce dallo schermo (drops[i] * fontSize > canvas.height),
        // ha una piccola probabilità (2.5%) di essere reimpostata in alto
        if (drops[i] * fontSize > canvas.height && Math.random() > 0.975) {
          drops[i] = 0;
        }

        // Incrementa la posizione verticale di ogni colonna, così che alla prossima iterazione il
        // carattere venga disegnato più in basso
        drops[i]++;
      }
    };

    // La funzione draw viene eseguita ogni 'speed' millisecondi tramite setInterval
    const interval = setInterval(draw, speed);

    // Quando il componente viene smontato, si cancellano l'intervallo e il gestore di evento per il ridimensionamento della finestra
    return () => {
      clearInterval(interval);
      window.removeEventListener("resize", resizeCanvas);
    };
  }, [fontSize, color, speed, characters, backgroundOpacity]); // Aggiorna l'effetto quando cambiano le props

  // Il <canvas> è un elemento HTML che permette di disegnare grafici, immagini e animazioni direttamente nella pagina web.
  // Funziona come una tela (come un foglio di carta) su cui puoi "disegnare" usando JavaScript.
  return <canvas ref={canvasRef} className="fixed top-0 left-0 w-full h-full z-0" />;
};

export default DigitalRain;