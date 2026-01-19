import React, { FC } from "react";
import FooterProps from "./index.types"

const Footer: FC<FooterProps> = ({ }) => {
  return <>
  <footer className="border-t border-[#00FF41]/30 backdrop-blur-sm bg-black/70 py-8">
          <div className="container mx-auto px-4 text-center">
            <p className="mb-4">© {new Date().getFullYear()} The Matrix | This is not the real world</p>
            <p className="text-sm text-[#00FF41]/70">&quot;Remember, all I&apos;m offering is the truth. Nothing more.&quot;</p>
          </div>
        </footer>
  </>
}

export default Footer