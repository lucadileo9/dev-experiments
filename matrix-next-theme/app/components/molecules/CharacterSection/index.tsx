import React, { FC } from "react";
import CharacterSectionProps from "./index.types"

const CharacterSection: FC<CharacterSectionProps> = ({ }) => {
  return <>
  <section id="characters" className="py-20">
            <div className="container mx-auto px-4">
              <h2 className="text-3xl md:text-4xl font-bold mb-12 text-center tracking-wider">
                <span className="border-b-2 border-[#00FF41] pb-2">Key Characters</span>
              </h2>
              <div className="grid md:grid-cols-3 gap-8">
                {[
                  {
                    name: "Neo",
                    role: "The One",
                    description: "A computer programmer who becomes the savior of mankind.",
                  },
                  {
                    name: "Morpheus",
                    role: "Captain",
                    description: "A resistance leader who believes Neo is The One.",
                  },
                  {
                    name: "Trinity",
                    role: "First Mate",
                    description: "A skilled hacker and resistance member who falls in love with Neo.",
                  },
                  {
                    name: "Agent Smith",
                    role: "Agent",
                    description: "A sentient program designed to eliminate threats to the Matrix.",
                  },
                  { name: "Oracle", role: "Program", description: "A program with the ability to predict the future." },
                  { name: "Cypher", role: "Operator", description: "A crew member who betrays the resistance." },
                ].map((character, index) => (
                  <div
                    key={index}
                    className="border border-[#00FF41]/30 bg-black/50 p-6 hover:bg-[#001a00] transition-colors duration-300"
                  >
                    <h3 className="text-xl font-bold mb-2">{character.name}</h3>
                    <p className="text-[#00FF41]/70 mb-4">{character.role}</p>
                    <p>{character.description}</p>
                  </div>
                ))}
              </div>
            </div>
          </section></>
}

export default CharacterSection