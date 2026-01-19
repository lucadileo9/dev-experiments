import React, { FC } from "react";
import TextProps from "./index.types"

const Text: FC<TextProps> = ({ data}) => {
  return   ( 
  <div className="text">{
    data.content}
  </div>
  )

}

export default Text