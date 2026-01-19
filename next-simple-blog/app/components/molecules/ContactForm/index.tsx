import React, { FC } from "react";
import ContactFormProps from "./index.types"

const ContactForm: FC<ContactFormProps> = ({ data }) => {
  return ( 
  <div className="contact-form">
    <h2>Contattaci</h2>
    <p>Email: {data.email}</p>
    <p>Telefono: {data.phone}</p>
</div>
  )
}

export default ContactForm