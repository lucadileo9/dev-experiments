"use client"


import DigitalRain from "@molecules/DigitalRain"
import Header from "@molecules/Header"
import Footer from "@molecules/Footer"
import Hero from "@molecules/Hero"
import AboutSection from "@molecules/AboutSection"
import ContactSection from "@molecules/ContactSection"
import CharacterSection from "@molecules/CharacterSection"
import QuoteSection from "@molecules/QuoteSection"
import WhiteRabbit from "@atoms/Rabbit"
import { useEffect } from "react"

export default function MatrixWebsite() {

  useEffect(() => {
    // Aggiungi un commento al DOM
    const comment = document.createComment("The Matrix has you. Wake up, Neo...");
    document.body.appendChild(comment);
  }, []);
  
  console.log(`
    %cWelcome to the Real World.
    Follow the white rabbit...
  `, "color: green; font-size: 20px;");
  return (
    <div className="min-h-screen bg-black text-[#00FF41] font-mono overflow-hidden relative">
      {/* Digital Rain Canvas Background */}
      <DigitalRain 
      fontSize = {14}
      color = "#00FF41"
      speed = {35}
      characters = "アイウエオカキクケコサシスセソタチツテトナニヌネノハヒフヘホマミムメモヤユヨラリルレロワヲン0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"    
      />

      {/* Content Container */}
      <div className="relative z-10">
        <Header />

        {/* Main Content */}
        <main>
          {/* Hero Section */}
          <Hero />

          {/* About Section */}
          <AboutSection />

          <CharacterSection />

          <QuoteSection />
          {/* Contact Section */}
          <ContactSection />
          <WhiteRabbit
              visibilityDuration={2000} // Visibile per 2 secondi
              reappearanceIntervalMin={3000} // Riapparizione minima: 3 secondi
              reappearanceIntervalMax={10000} // Riapparizione massima: 15 secondi
              onClick={() => window.location.href = "/secret"} // Reindirizza all'url segreto
            />
          </main>

        <Footer />
      </div>
    </div>
  )
}
