"use client"

import { useEffect, useState } from "react"
import { ArrowLeft, Lock, Eye, EyeOff } from "lucide-react"
import Link from "next/link"
import TypewriterEffect from "@molecules/TypewriterEffect"
import { Button } from "../../components/ui/button"
import DigitalRain from "@molecules/DigitalRain"
import EmergencyContact from "@molecules/EmergencyContact"
import SecretInfo from "@molecules/SecretInfo"


export default function SecretPage() {
  const [showContent, setShowContent] = useState(false)

  useEffect(() => {
    const timer = setTimeout(() => {
      setShowContent(true)
    }, 1000)

    return () => clearTimeout(timer)
  }, [])


  

  return  ( 

    
    <div className="min-h-screen bg-black text-[#00FF41] font-mono overflow-hidden relative p-6">
        <DigitalRain
          fontSize={8} 
          color="#FF0000" 
          speed={500} 
          characters="no" 
        />

        <div className=""> 
          {/* Mettere relative e z-10 per fare in modo che il contenutio non venga coperto dal digital rain */}

      <main className="max-w-4xl mx-auto">

        <div className={`transition-opacity duration-1000 ${showContent ? "opacity-100" : "opacity-0"}`}>
        
          <h1 className="text-4xl font-bold mb-8 glitch-text">
            <TypewriterEffect text="Informazioni Top Secret" delay={50} startDelay={2000} />
          </h1>
          <SecretInfo   />

          
          <EmergencyContact />

          
        </div>
      </main>
      </div>
    </div>
  )

}

