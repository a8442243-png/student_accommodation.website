<?php
include("includes/db.php");
include("includes/header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Accommodation</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<section class="bg-light py-5 text-center">
    <div class="container">
        <h1>Find Your Perfect PG</h1>
        <p class="lead">Affordable student accommodation across India.</p>
    </div>
</section>

<div class="container my-5">
    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <h4 class="mb-3">🔎 Find Your Perfect PG</h4>

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">City</label>

                    <select id="cityFilter" class="form-select">
                        <option value="">All Cities</option>

                        <?php
                        $cityQuery = "SELECT DISTINCT city FROM properties ORDER BY city";
                        $cityResult = $conn->query($cityQuery);

                        while ($city = $cityResult->fetch_assoc()) {
                        ?>

                            <option value="<?php echo htmlspecialchars($city['city']); ?>">
                                <?php echo htmlspecialchars($city['city']); ?>
                            </option>

                        <?php } ?>

                    </select>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">Maximum Budget</label>

                    <select id="budgetFilter" class="form-select">

                        <option value="">Any Budget</option>
                        <option value="5000">₹5,000</option>
                        <option value="8500">₹8,500</option>
                        <option value="10000">₹10,000</option>
                        <option value="15000">₹15,000</option>

                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Gender</label>

                    <select id="genderFilter" class="form-select">

                        <option value="">All</option>
                        <option value="Boys">Male</option>
                        <option value="Girls">Female</option>
                        <option value="Any">Any</option>

                    </select>
                </div>

            </div>


            <div class="mt-3">

                <button
                    type="button"
                    class="btn btn-primary"
                    onclick="filterProperties()"
                >
                    🔍 Apply Filters
                </button>

                <button
                    type="button"
                    class="btn btn-secondary"
                    onclick="resetFilters()"
                >
                    Reset
                </button>

            </div>

        </div>
    </div>

    <div
        id="loading"
        class="text-center my-4"
        style="display:none;"
    >

        <div class="spinner-border text-primary"></div>

        <p class="mt-2">
            Loading properties...
        </p>

</div>
    <div class="row" id="propertyList">
<?php

$sql = "SELECT * FROM properties";
$result = $conn->query($sql);

while($row = $result->fetch_assoc())
{
?>

<div class="col-md-3 mb-4">

<div class="card shadow">
<img src="https://picsum.photos/400/250?random=<?php echo $row['id']; ?>" class="card-img-top" height="220">
<div class="card-body">
<h5><?php echo $row['name']; ?></h5>
<p><strong>City:</strong> <?php echo $row['city']; ?></p>
<p><strong>Price:</strong> ₹<?php echo $row['price']; ?>/month</p>
<p><strong>Gender:</strong> <?php echo $row['gender']; ?></p>
<p>⭐ <?php echo $row['rating']; ?></p>
<a href="property.php?id=<?php echo $row['id']; ?>" class="btn btn-primary w-100">
View Details
</a>
</div>
</div>
</div>
<?php
}
?>
    </div>
</div>
<footer class="bg-dark text-white text-center p-3">
    © 2026 Student Accommodation
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>