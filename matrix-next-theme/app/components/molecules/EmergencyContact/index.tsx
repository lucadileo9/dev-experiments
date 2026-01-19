import React, { FC, useState } from "react";
import EmergencyContactProps from "./index.types"
import { EyeOff, Eye } from "lucide-react";
import { Button } from "../../ui/button";

const EmergencyContact: FC<EmergencyContactProps> = ({ }) => {
  const [showPassword, setShowPassword] = useState(false)

  return <>
  <div className="border border-[#00FF41]/30 bg-black/50 p-6">
            <h2 className="text-2xl font-bold mb-4">Codice di Accesso Emergenza</h2>
            <div className="flex items-center">
              <input
                type={showPassword ? "text" : "password"}
                className="bg-black border border-[#00FF41] text-[#00FF41] px-4 py-2 flex-grow mr-2"
                value="Z10N-0R4CL3-N30"
                readOnly
              />
              <Button
                variant="outline"
                size="icon"
                onClick={() => setShowPassword(!showPassword)}
                className="border-[#00FF41] text-[#00FF41]"
              >
                {showPassword ? <EyeOff className="h-4 w-4" /> : <Eye className="h-4 w-4" />}
              </Button>
            </div>
            <p className="mt-2 text-sm text-[#00FF41]/70">
              Usa questo codice solo in caso di emergenza estrema per la disconnessione immediata.
            </p>
          </div></>
}

export default EmergencyContact