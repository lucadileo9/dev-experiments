"use client";
import { useState } from "react";

const Oracle = () => {
  // Array di previsioni casuali
  const predictions = [
    "You will find what you seek.",
    "The path is clear, but the journey is long.",
    "Do not fear change; embrace it.",
    "There is no spoon.",
    "Trust in yourself, and all will be revealed.",
    "Everything begins with a choice.",
    "The answer lies within you.",
    "Follow the white rabbit.",
    "Ignorance is bliss, but knowledge is power.",
    "You have the sight now, Neo.",
  ];

  // Stato per memorizzare la previsione corrente
  const [oraclePrediction, setOraclePrediction] = useState("");

  // Funzione per generare una previsione casuale
  const getOraclePrediction = () => {
    const randomIndex = Math.floor(Math.random() * predictions.length);
    setOraclePrediction(predictions[randomIndex]);
  };

  return (
    <div className="bg-black text-white p-8 rounded-lg shadow-lg max-w-md mx-auto mt-10 flex flex-col items-center">
      <h2 className="text-2xl font-bold text-green-500 mb-4">Ask the Oracle</h2>
      <button
        onClick={getOraclePrediction}
        className="bg-green-500 hover:bg-green-600 text-black font-semibold py-2 px-4 rounded mb-4"
      >
        Get Prediction
      </button>
      {oraclePrediction && (
        <p className="text-lg font-medium italic text-gray-300">
          &quot;{oraclePrediction}&quot;
        </p>
      )}
    </div>
  );
};

export default Oracle;