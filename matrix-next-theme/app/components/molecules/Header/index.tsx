import React, { FC, useState } from "react";
import HeaderProps from "./index.types"
import { X, Menu } from "lucide-react";
import Link from "next/link";

const Header: FC<HeaderProps> = ({ }) => {
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false)
  
  return <>
  <header className="border-b border-[#00FF41]/30 backdrop-blur-sm bg-black/70">
          <div className="container mx-auto px-4 py-4 flex justify-between items-center">
            <Link href="/" className="text-2xl font-bold tracking-wider glitch-text">
              <span className="text-[#00FF41]">THE MATRIX</span>
            </Link>

            {/* Desktop Navigation */}
            <nav className="hidden md:flex space-x-8">
              {["Home", "About", "Characters", "Quotes", "Contact"].map((item) => (
                <Link
                  key={item}
                  href={`#${item.toLowerCase()}`}
                  className="hover:text-white transition-colors duration-300 tracking-wide"
                >
                  {item}
                </Link>
              ))}
            </nav>

            {/* Mobile Menu Button */}
            <button className="md:hidden text-[#00FF41]" onClick={() => setMobileMenuOpen(!mobileMenuOpen)}>
              {mobileMenuOpen ? <X size={24} /> : <Menu size={24} />}
            </button>
          </div>

          {/* Mobile Navigation */}
          {mobileMenuOpen && (
            <nav className="md:hidden border-t border-[#00FF41]/30 backdrop-blur-sm bg-black/90">
              <div className="container mx-auto px-4 py-4 flex flex-col space-y-4">
                {["Home", "About", "Characters", "Quotes", "Contact"].map((item) => (
                  <Link
                    key={item}
                    href={`#${item.toLowerCase()}`}
                    className="hover:text-white transition-colors duration-300 tracking-wide py-2"
                    onClick={() => setMobileMenuOpen(false)}
                  >
                    {item}
                  </Link>
                ))}
              </div>
            </nav>
          )}
        </header>
  </>
}

export default Header