'use client';
import React, { FC } from "react";
import AdminHeaderProps from "./index.types"
import Link from "next/link";

const AdminHeader: FC<AdminHeaderProps> = ({ }) => {
  return        (  
  <header className="bg-purple text-beige p-4">
  <nav className="container mx-auto flex justify-between items-center">
    <Link href="/" className="text-2xl font-bold">Logo</Link>
    <ul className="flex space-x-4">
      <li><Link href="/admin" className="hover:underline">Gestisci Pagine</Link></li>
      <li><Link href="/admin/blog" className="hover:underline">Gestisci Blog</Link></li>
      <li><Link href="/admin/register" className="hover:underline">Registra Utente</Link></li>
    </ul>
    <button
            onClick={handleLogout}
            className="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition-colors"
          >
            Logout
          </button>
  </nav>
</header>
  )
  async function handleLogout() {
    try {
      const response = await fetch('/api/admin/logout', {
        method: 'POST',
        credentials: 'include',
      });

      if (response.ok) {
        alert('Logout effettuato con successo!');
        window.location.href = '/';
      } else {
        alert('Errore durante il logout.');
      }
    } catch (error) {
      console.error(error);
      alert('Si è verificato un errore durante il logout.');
    }
  }

}

export default AdminHeader