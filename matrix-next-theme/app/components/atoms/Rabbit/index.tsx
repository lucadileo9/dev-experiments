import { useEffect } from "react";

const WhiteRabbit = ({
  visibilityDuration = 1000, // Durata della visibilità (default: 1 secondo)
  reappearanceIntervalMin = 5000, // Intervallo minimo di riapparizione (default: 5 secondi)
  reappearanceIntervalMax = 10000, // Intervallo massimo di riapparizione (default: 10 secondi)
  onClick = () => {}, // Funzione da eseguire al click (default: nulla)
}) => {
  useEffect(() => {
    const rabbit = document.getElementById("whiteRabbit");

    // Funzione per mostrare il coniglio
    function showRabbit() {
      if (!rabbit) return;

      // Posiziona il coniglio in una posizione casuale
      const randomTop = Math.random() * (window.innerHeight - 40);
      const randomLeft = Math.random() * (window.innerWidth - 20);

      rabbit.style.top = `${randomTop}px`;
      rabbit.style.left = `${randomLeft}px`;

      // Rendi il coniglio visibile
      rabbit.style.opacity = "1";

      // Nascondi il coniglio dopo la durata specificata
      setTimeout(() => {
        rabbit.style.opacity = "0";
        // Programma la prossima apparizione tra reappearanceIntervalMin e reappearanceIntervalMax
        const randomDelay =
          reappearanceIntervalMin + Math.random() * (reappearanceIntervalMax - reappearanceIntervalMin);
        setTimeout(showRabbit, randomDelay);
      }, visibilityDuration);
    }

    // Avvia la prima apparizione dopo un breve ritardo iniziale
    setTimeout(showRabbit, 8000); // Prima apparizione dopo 8 secondi

    // Gestisci il click sul coniglio
    if (rabbit) {
      rabbit.addEventListener("click", () => {
        // Controlla se l'opacità è maggiore di 0 (visibile)
        if (parseFloat(window.getComputedStyle(rabbit).opacity) > 0) {
          onClick(); // Esegui la funzione passata come prop solo se visibile
        }
      });
    }

    // Pulizia degli eventi quando il componente viene smontato
    return () => {
      if (rabbit) {
        rabbit.removeEventListener("click", () => {});
      }
    };
  }, [visibilityDuration, reappearanceIntervalMin, reappearanceIntervalMax, onClick]);

  return (
    <div
      id="whiteRabbit"
      className="absolute text-xs text-[#39FF14]/50 transition-opacity duration-300 cursor-pointer opacity-0"
    >
      🐇
    </div>
  );
};

export default WhiteRabbit;