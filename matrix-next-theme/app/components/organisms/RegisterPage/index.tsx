'use client'
import React, { FC, useState } from "react";
import RegisterPageProps from "./index.types"
import TypewriterEffect from "@molecules/TypewriterEffect";
import { UserPlus } from "lucide-react";
import { Button } from "../../ui/button";
import { Input } from "../../ui/input";
import Link from "next/link";
import DigitalRain from "@molecules/DigitalRain";

const RegisterPage: FC<RegisterPageProps> = ({ }) => {
  const [username, setUsername] = useState("")
  const [email, setEmail] = useState("")
  const [password, setPassword] = useState("")
  const [confirmPassword, setConfirmPassword] = useState("")

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault()
    // Implementare la logica di registrazione qui
    console.log("Registration attempt:", { username, email, password, confirmPassword })
  }

  return (
    <div className="min-h-screen bg-black text-[#00FF41] font-mono overflow-hidden relative p-6">
      <DigitalRain
        fontSize={2}
        color="#00FF41"
        speed={1}
        characters="123456789"
      />

      <div className="max-w-md mx-auto relative z-10">


        <div className="border border-[#00FF41]/30 bg-black/50 p-6">
          <h1 className="text-3xl font-bold mb-6 glitch-text">
            <TypewriterEffect text="Registrazione alla Matrix" delay={50} />
          </h1>

          <form onSubmit={handleSubmit} className="space-y-4">
            <div>
              <label htmlFor="username" className="block mb-2">
                Nome Utente
              </label>
              <Input
                id="username"
                type="text"
                value={username}
                onChange={(e) => setUsername(e.target.value)}
                className="w-full bg-black border-[#00FF41] text-[#00FF41]"
                required
              />
            </div>
            <div>
              <label htmlFor="email" className="block mb-2">
                Email
              </label>
              <Input
                id="email"
                type="email"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                className="w-full bg-black border-[#00FF41] text-[#00FF41]"
                required
              />
            </div>
            <div>
              <label htmlFor="password" className="block mb-2">
                Password
              </label>
              <Input
                id="password"
                type="password"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                className="w-full bg-black border-[#00FF41] text-[#00FF41]"
                required
              />
            </div>
            <div>
              <label htmlFor="confirmPassword" className="block mb-2">
                Conferma Password
              </label>
              <Input
                id="confirmPassword"
                type="password"
                value={confirmPassword}
                onChange={(e) => setConfirmPassword(e.target.value)}
                className="w-full bg-black border-[#00FF41] text-[#00FF41]"
                required
              />
            </div>
            <Button type="submit" className="w-full bg-[#00FF41] text-black hover:bg-[#00FF41]/80">
              <UserPlus className="mr-2 h-4 w-4" /> Registrati
            </Button>
          </form>

          <div className="mt-4 text-center">
            <p>
              Hai già un account?{" "}
              <Link href="/login" className="text-[#00FF41] hover:text-white underline">
                Accedi
              </Link>
            </p>
          </div>
        </div>
      </div>
    </div>
  )
}

export default RegisterPage