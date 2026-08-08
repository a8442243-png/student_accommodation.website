<?php
include("includes/db.php");
include("includes/header.php");

$properties = [];
$result = $conn->query("SELECT id, name, city, price, gender, rating, image, description FROM properties ORDER BY id");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $properties[] = $row;
    }
}
?>

<div class="container py-5">
    <div class="text-center mb-4">
        <h1>React Property Listing</h1>
        <p class="text-muted">Property cards rendered using React.</p>
    </div>

    <div id="react-property-root"></div>
</div>

<!-- React -->
<script src="https://unpkg.com/react@18/umd/react.development.js"></script>
<script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
<script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>

<script>
    window.pgProperties = <?php echo json_encode($properties, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
</script>

<script type="text/babel">
    const { useState } = React;

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
                                    <a
                                        href={`property.php?id=${property.id}`}
                                        className="btn btn-primary w-100"
                                    >
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>

                {filtered.length === 0 && (
                    <div className="alert alert-warning text-center mt-4">
                        No properties found for this city.
                    </div>
                )}
            </>
        );
    }

    const root = ReactDOM.createRoot(document.getElementById("react-property-root"));
    root.render(<PropertyList properties={window.pgProperties} />);
</script>

<?php include("includes/footer.php"); ?>
