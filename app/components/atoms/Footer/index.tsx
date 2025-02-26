import React, { FC } from "react";
import FooterProps from "./index.types"

const Footer: FC<FooterProps> = ({ }) => {
  return (
    <footer className="bg-purple text-beige p-4 mt-8">
    <div className="container mx-auto text-center">
      &copy; 2025 Simple Purple & Beige Website. All rights reserved.
    </div>
  </footer>

  )
}

export default Footer