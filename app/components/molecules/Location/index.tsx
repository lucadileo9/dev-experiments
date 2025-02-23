import React, { FC } from "react";
import LocationProps from "./index.types"

const Location: FC<LocationProps> = ({ data}) => {
  return (
    <div className="location">
      <p>Indirizzo: {data.address}</p>
      {/* <iframe src={data.mapUrl} width="100%" height="300" /> */}
  </div>

  )
}

export default Location