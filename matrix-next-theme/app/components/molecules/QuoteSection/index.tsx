import React, { FC } from "react";
import QuoteSectionProps from "./index.types"

const QuoteSection: FC<QuoteSectionProps> = ({ }) => {
  return <>
  <section id="quotes" className="py-20 backdrop-blur-sm bg-black/70">
            <div className="container mx-auto px-4">
              <h2 className="text-3xl md:text-4xl font-bold mb-12 text-center tracking-wider">
                <span className="border-b-2 border-[#00FF41] pb-2">Iconic Quotes</span>
              </h2>
              <div className="grid md:grid-cols-2 gap-8">
                {[
                  { quote: "I know kung fu.", character: "Neo" },
                  { quote: "There is no spoon.", character: "The Boy" },
                  { quote: "Free your mind.", character: "Morpheus" },
                  { quote: "Ignorance is bliss.", character: "Cypher" },
                  { quote: "Never send a human to do a machine's job.", character: "Agent Smith" },
                  {
                    quote: "I can only show you the door. You're the one that has to walk through it.",
                    character: "Morpheus",
                  },
                ].map((item, index) => (
                  <div key={index} className="border border-[#00FF41]/30 bg-black/50 p-6">
                    <blockquote className="text-xl italic mb-4">&quot;{item.quote}&quot;</blockquote>
                    <p className="text-right text-[#00FF41]/70">— {item.character}</p>
                  </div>
                ))}
              </div>
            </div>
          </section>
</>
}

export default QuoteSection