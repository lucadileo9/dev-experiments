import React, { FC } from "react";
import CallToActionProps from "./index.types"
import { Button } from "../../ui/button";

const CallToAction: FC<CallToActionProps> = ({showContent }) => {
  return <>
   <section className="container mx-auto px-4 py-12 text-center">
            <div className={`transition-opacity duration-1000 ${showContent ? "opacity-100" : "opacity-0"}`}>
              <h2 className="text-2xl font-bold mb-6">Sei pronto a conoscere la verità?</h2>
              <div className="flex flex-col sm:flex-row gap-4 justify-center">
                <Button className="bg-[#00FF41] text-black hover:bg-[#00FF41]/80 border border-[#00FF41] px-8 py-6">
                  Unisciti alla Resistenza
                </Button>
                <Button variant="outline" className="border-[#00FF41] text-[#00FF41] hover:bg-[#00FF41]/10 px-8 py-6">
                  Scopri di Più
                </Button>
              </div>
            </div>
          </section></>
}

export default CallToAction