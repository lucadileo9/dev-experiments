'use client'

import React, { FC, useState } from "react";
import LoginPageProps from "./index.types"
import TypewriterEffect from "@molecules/TypewriterEffect";
import {  Lock } from "lucide-react";
import Link from "next/link";
import { Button } from "../../ui/button";
import { Input } from "../../ui/input";
import DigitalRain from "@molecules/DigitalRain";

const LoginPage: FC<LoginPageProps> = ({ }) => {
  const [username, setUsername] = useState("")
  const [password, setPassword] = useState("")

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault()
    // Implementare la logica di login qui
    console.log("Login attempt:", { username, password })
  }

  return (
    <div className="min-h-screen bg-black text-[#00FF41] font-mono overflow-hidden relative p-6">
      {/* Digital Rain Canvas Background */}
      <DigitalRain
        fontSize={2}
        color="#00FF41"
        speed={1}
        characters="123456789"
      />
      <div className="max-w-md mx-auto relative z-10">
        

        <div className="border border-[#00FF41]/30 bg-black/50 p-6">
          <h1 className="text-3xl font-bold mb-6 glitch-text">
            <TypewriterEffect text="Accesso alla Matrix" delay={50} />
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
            <Button type="submit" className="w-full bg-[#00FF41] text-black hover:bg-[#00FF41]/80">
              <Lock className="mr-2 h-4 w-4" /> Accedi
            </Button>
          </form>

          <div className="mt-4 text-center">
            <p>
              Non hai un account?{" "}
              <Link href="/register" className="text-[#00FF41] hover:text-white underline">
                Registrati
              </Link>
            </p>
          </div>
        </div>
      </div>
    </div>
  )
}


export default LoginPage