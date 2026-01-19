import React, { FC } from "react";
import HeaderProps from "./index.types"
import Link from "next/link";

const Header: FC<HeaderProps> = ({ }) => {
  return        (   
  <header className="bg-purple text-beige p-4">
  <nav className="container mx-auto flex justify-between items-center">
    <Link href="/" className="text-2xl font-bold">Logo</Link>

    <ul className="flex space-x-4">
      <li><Link href="/" className="hover:underline">Home</Link></li>
      <li><Link href="/about" className="hover:underline">About</Link></li>
      <li><Link href="/contact" className="hover:underline">Contact</Link></li>
      <li><Link href="/blog" className="hover:underline">Blog</Link></li>
    </ul>

  </nav>
</header>
  )

}

export default Header