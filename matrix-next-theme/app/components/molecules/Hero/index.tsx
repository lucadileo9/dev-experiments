
import React, { FC, useEffect, useState } from "react";
import HeroProps from "./index.types"
import TypewriterEffect from "@molecules/TypewriterEffect";
import { ChevronDown } from "lucide-react";
import { Button } from "../../ui/button";


const Hero: FC<HeroProps> = ({ }) => {
  const [showContent, setShowContent] = useState(false)

useEffect(() => {
  // Simulate the Matrix "wake up" effect
  const timer = setTimeout(() => {
    setShowContent(true)
  }, 2000)

  return () => clearTimeout(timer)
}, [])

  return <>
  <section id="home" className="min-h-[90vh] flex flex-col items-center justify-center text-center px-4 py-20">
            <div className={`transition-opacity duration-1000 ${showContent ? "opacity-100" : "opacity-0"}`}>
              <h1 className="text-4xl md:text-6xl font-bold mb-6 tracking-tight leading-tight">
                <TypewriterEffect text="Welcome to the Matrix" delay={100} startDelay={2000}/>
              </h1>
              <p className="text-xl md:text-2xl max-w-3xl mx-auto mb-8 text-[#00FF41]/80">
                <TypewriterEffect
                  text="What is real? How do you define real? If you're talking about what you can feel, what you can smell, what you can taste and see, then real is simply electrical signals interpreted by your brain."
                  delay={50}
                  startDelay={4500}
                />
              </p>
              <div className="flex flex-col sm:flex-row gap-4 justify-center mt-8">
                <Button className="bg-[#00FF41] text-black hover:bg-[red]/60 hover:text-[#00FF41]
                 border border-[#00FF41] px-8 py-6 text-lg">
                  Take the Red Pill
                </Button>
                <Button
                  variant="outline"
                  className="border-[#00FF41] text-[#00FF41] hover:bg-[blue]/60 px-8 py-6 text-lg"
                >
                  Take the Blue Pill
                </Button>
              </div>
            </div>
            <div className="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
              <ChevronDown size={32} />
            </div>
          </section>
</>
}

export default Hero