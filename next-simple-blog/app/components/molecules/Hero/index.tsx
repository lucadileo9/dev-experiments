import React, { FC } from "react";
import HeroProps from "./index.types"
import Image from "next/image";

const Hero: FC<HeroProps> = ({ data }) => {
  return (
    <div className= "text-xl text-purple-800">
      <h1>{data.title}</h1>
      <p>{data.subtitle}</p>
      {/* <Image src={data.image} alt="Hero" layout="responsive" width={10} height={10} /> */}
  </div>

  )
}

export default Hero