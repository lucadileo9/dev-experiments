import React, { FC } from "react";
import AboutSectionProps from "./index.types"

const AboutSection: FC<AboutSectionProps> = ({ }) => {
  return <>
  <section id="about" className="py-20 backdrop-blur-sm bg-black/70">
            <div className="container mx-auto px-4">
              <h2 className="text-3xl md:text-4xl font-bold mb-12 text-center tracking-wider">
                <span className="border-b-2 border-[#00FF41] pb-2">About The Matrix</span>
              </h2>
              <div className="grid md:grid-cols-2 gap-12 items-center">
                <div>
                  <p className="text-lg mb-6 leading-relaxed">
                    The Matrix is a 1999 science fiction action film written and directed by the Wachowskis. It depicts
                    a dystopian future in which humanity is unknowingly trapped inside a simulated reality, the Matrix,
                    created by intelligent machines to distract humans while using their bodies as an energy source.
                  </p>
                  <p className="text-lg mb-6 leading-relaxed">
                    When computer programmer Thomas Anderson, under the hacker alias &qout;Neo&qout;, uncovers the truth, he joins
                    a rebellion against the machines along with other people who have been freed from the Matrix.
                  </p>
                </div>
                <div className="border border-[#00FF41]/30 p-1 bg-black/50">
                  <div className="aspect-video bg-[#001a00] flex items-center justify-center border border-[#00FF41]/50 overflow-hidden">
                    <div className="text-center p-8">
                      <h3 className="text-2xl mb-4 glitch-text">The Matrix Has You</h3>
                      <p className="text-[#00FF41]/70 mb-4">Follow the white rabbit.</p>
                      <div className="flex justify-center">
                        <div className="w-32 h-32 border border-[#00FF41] flex items-center justify-center">
                          <div className="digital-code text-xs overflow-hidden h-full w-full p-2">
                            01001110 01100101 01101111 00001010 01010111 01100001 01101011 01100101 00100000 01110101
                            01110000
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
</>
}

export default AboutSection