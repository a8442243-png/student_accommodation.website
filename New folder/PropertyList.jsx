import React from "react";

function PropertyList({property}){

return(

<div className="card">

<img
src={`https://picsum.photos/300/200?random=${property.id}`}
className="card-img-top"
/>

<div className="card-body">

<h5>{property.name}</h5>

<p>{property.city}</p>

<p>₹{property.price}</p>

</div>

</div>

);

}

export default PropertyList;