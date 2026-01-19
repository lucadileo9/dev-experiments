import React, { FC, useEffect, useState } from "react";
import RulesHeroProps from "./index.types"
import TypewriterEffect from "@molecules/TypewriterEffect";
import { Menu, X, ArrowLeft, Shield, AlertTriangle, Lock, Eye, Code, Zap } from "lucide-react"

const RulesHero: FC<RulesHeroProps> = ({ showContent }) => {

 
  return <>
  <section className="container mx-auto px-4 py-8 text-center">
            <div className={`transition-opacity duration-1000 ${showContent ? "opacity-100" : "opacity-0"}`}>
              <h1 className="text-4xl md:text-5xl font-bold mb-6 tracking-tight leading-tight glitch-text">
              <TypewriterEffect text="Protocollo di Sicurezza" delay={100} startDelay={2000}/>

              </h1>
              <p className="text-xl max-w-3xl mx-auto mb-8 text-[#00FF41]/80">
              <TypewriterEffect
                  text="
                  Queste regole sono fondamentali per la sopravvivenza all'interno e all'esterno della Matrix. Memorizzale. La tua vita dipende da esse"
                  delay={50}
                  startDelay={4500}
                />
              </p>
              <div className="flex justify-center mb-8">
                <Lock className="h-16 w-16 text-[#00FF41] animate-pulse" />
              </div>
            </div>
          </section>
</>
}

export default RulesHero