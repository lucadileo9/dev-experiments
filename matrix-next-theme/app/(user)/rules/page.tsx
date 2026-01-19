"use client"
import { useEffect, useState } from "react"
import { Menu, X, ArrowLeft, Shield, AlertTriangle, Lock, Eye, Code, Zap } from "lucide-react"
import Link from "next/link"
import { Button } from "../components/ui/button"
import DigitalRain from "@molecules/DigitalRain"
import Head from "next/head"
import Header from "@molecules/Header"
import TypewriterEffect from "@molecules/TypewriterEffect"
import { Rule } from "postcss"
import RulesHero from "@molecules/RulesHero"
import CallToAction from "@molecules/CallToAction"
import RulesContent from "@molecules/RulesContent"

export default function RulesPage() {

  const [showContent, setShowContent] = useState(false)

  useEffect(() => {
    // Simulate the Matrix "wake up" effect
    const timer = setTimeout(() => {
      setShowContent(true)
    }, 1500)

    return () => clearTimeout(timer)
  }, [])

  

  return (
    <div className="min-h-screen bg-black text-[#00FF41] font-mono overflow-hidden relative">
      {/* Digital Rain Canvas Background */}
        <DigitalRain />
        <Header />

      {/* Content Container */}
      <div className="relative z-10">
        
        {/* Main Content */}
        <main>
            <RulesHero showContent={showContent} />   
          

          
          {/* Rules Content */}
          <RulesContent showContent={showContent} />


          {/* Call to Action */}
         <CallToAction showContent={showContent}/>
        </main>

        
      </div>
    </div>
  )
}

