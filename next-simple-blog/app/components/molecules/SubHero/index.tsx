import React, { FC } from "react";
import SubHeroProps from "./index.types"

const SubHero: FC<SubHeroProps> = ({data  }) => {
  return (
    <div className="bg-purple-100 p-8 rounded-lg">
    <h2 className="text-2xl font-semibold text-purple mb-4">{data.title}</h2>
    <p className="text-purple-800">{data.content}</p>
  </div>

  )
}

export default SubHero