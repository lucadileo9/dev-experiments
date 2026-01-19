import React, { FC } from "react";
import ContactSectionProps from "./index.types"
import { Button } from "../../ui/button";

const ContactSection: FC<ContactSectionProps> = ({ }) => {
  return <><section id="contact" className="py-20">
  <div className="container mx-auto px-4">
    <h2 className="text-3xl md:text-4xl font-bold mb-12 text-center tracking-wider">
      <span className="border-b-2 border-[#00FF41] pb-2">Contact Us</span>
    </h2>
    <div className="max-w-md mx-auto">
      <div className="border border-[#00FF41]/30 bg-black/50 p-6">
        <p className="mb-6 text-center">Leave a message for the Oracle</p>
        <form className="space-y-4">
          <div>
            <input
              type="text"
              placeholder="Name"
              className="w-full bg-black border border-[#00FF41]/50 p-3 text-[#00FF41] focus:border-[#00FF41] focus:outline-none"
            />
          </div>
          <div>
            <input
              type="email"
              placeholder="Email"
              className="w-full bg-black border border-[#00FF41]/50 p-3 text-[#00FF41] focus:border-[#00FF41] focus:outline-none"
            />
          </div>
          <div>
            <textarea
              placeholder="Message"
              rows={4}
              className="w-full bg-black border border-[#00FF41]/50 p-3 text-[#00FF41] focus:border-[#00FF41] focus:outline-none"
            ></textarea>
          </div>
          <Button className="w-full bg-[#00FF41] text-black hover:bg-[#00FF41]/80 border border-[#00FF41]">
            Send Message
          </Button>
        </form>
      </div>
    </div>
  </div>
</section>
</>
}

export default ContactSection