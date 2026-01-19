import React, { FC } from "react";
import ModuleProps from "./index.types"
import Hero from "../Hero";
import SubHero from "../SubHero";
import Location from "../Location";
import Text from "../Text";
import ContactForm from "../ContactForm";

const Module: FC<ModuleProps> = ({ type, data }) => {
  const moduleComponents: { [key: string]: FC<any> } = {
    hero: Hero,
    'sub-hero': SubHero,
    location: Location,
    text: Text,
    contactForm: ContactForm,
  };
  // La key è il tipo di MODULO, il valore è il componente React
  const ModuleComponent = moduleComponents[type];
  if (!ModuleComponent) return null;

  return <ModuleComponent data={data} />;}

export default Module