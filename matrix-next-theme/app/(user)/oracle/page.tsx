'use client'
import Oracle from '@atoms/Oracle';
import DigitalRain from '@molecules/DigitalRain';
import TypewriterEffect from '@molecules/TypewriterEffect';
import React from 'react';

const OraclePage: React.FC = () => {
    return (
<div className="min-h-screen bg-black text-[#00FF41] font-mono overflow-hidden relative p-6">
    <DigitalRain
    fontSize={12}
    color="#FFFFFF"
    characters='abcdefghijklmnopqrstuvwxyz'
    speed={60}
    backgroundOpacity={0.4}
    />
    
      <div className="max-w-4xl mx-auto relative">
 

        <div className={`transition-opacity duration-1000 ${true ? "opacity-100" : "opacity-0"}`}>

          <h1 className="text-4xl font-bold mb-8 glitch-text text-center">
            <TypewriterEffect text="L'Oracolo" delay={50} />
          </h1>

          <div className="border border-[#00FF41]/30 bg-black/50 p-6 mb-8">
            <p className="mb-6 text-center">
              <TypewriterEffect
                text="L'Oracolo è un programma intuitivo, inizialmente creato per investigare alcuni aspetti della psiche umana. Possiede la capacità di leggere le emozioni delle persone e prevedere le loro reazioni e decisioni."
                delay={20}
              />
            </p>
            <p className="mb-6 text-center">
              <TypewriterEffect
                text="Ricorda: l'Oracolo ti dirà esattamente quello che hai bisogno di sentire. Niente di più, niente di meno."
                delay={20}
                startDelay={2000}
              />
            </p>
          </div>

          <Oracle />

          
        </div>
      </div>
    </div>
  )
}

export default OraclePage;