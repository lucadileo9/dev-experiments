import Module from "@molecules/Module";

import {pages} from "../../db";

export default function AboutUs() {
  const page = pages.contact;

  return ( 
      <div className="space-y-8">
      <h1 className="text-4xl font-bold text-purple mb-4">{page.title}</h1>
        {Object.entries(page.modules).map(([type, data], index) => (
              <Module key={index} type={type} data={data} />
            ))}  
      </div>
  )
}
