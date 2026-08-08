import React, { useState } from "react";

function PropertyList({ properties }) {
    const [selectedCity, setSelectedCity] = useState("");

    const cities = [...new Set(properties.map(property => property.city))];
    const filtered = selectedCity
        ? properties.filter(property => property.city === selectedCity)
        : properties;

    return (
        <>
            <div className="card shadow-sm mb-4">
                <div className="card-body">
                    <label className="form-label fw-bold">Filter by City</label>
                    <select
                        className="form-select"
                        value={selectedCity}
                        onChange={(e) => setSelectedCity(e.target.value)}
                    >
                        <option value="">All Cities</option>
                        {cities.map(city => (
                            <option key={city} value={city}>{city}</option>
                        ))}
                    </select>
                </div>
            </div>

            <div className="row g-4">
                {filtered.map(property => (
                    <div className="col-md-6 col-lg-4" key={property.id}>
                        <div className="card h-100 shadow-sm">
                            <img
                                src={`https://picsum.photos/500/300?random=${property.id}`}
                                className="card-img-top"
                                height="220"
                                style={{ objectFit: "cover" }}
                                alt={property.name}
                            />
                            <div className="card-body">
                                <h5 className="card-title">{property.name}</h5>
                                <p className="mb-1"><strong>City:</strong> {property.city}</p>
                                <p className="mb-1"><strong>Price:</strong> ₹{property.price}/month</p>
                                <p className="mb-1"><strong>Gender:</strong> {property.gender}</p>
                                <p className="mb-3">⭐ {property.rating}/5</p>
                                <a href={`property.php?id=${property.id}`} className="btn btn-primary w-100">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                ))}
            </div>
        </>
    );
}

export default PropertyList;
