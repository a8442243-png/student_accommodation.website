<?php

include("includes/db.php");

$city = isset($_POST['city']) ? trim($_POST['city']) : "";
$budget = isset($_POST['budget']) ? trim($_POST['budget']) : "";
$gender = isset($_POST['gender']) ? trim($_POST['gender']) : "";

$sql = "SELECT * FROM properties WHERE 1=1";

$params = [];
$types = "";

if ($city !== "" && $city !== "All Cities") {
    $sql .= " AND city = ?";
    $params[] = $city;
    $types .= "s";
}

if ($budget !== "" && is_numeric($budget)) {
    $sql .= " AND price <= ?";
    $params[] = (int)$budget;
    $types .= "i";
}

if ($gender !== "" && $gender !== "All") {
    $sql .= " AND gender = ?";
    $params[] = $gender;
    $types .= "s";
}

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo '
    <div class="col-12">
        <div class="alert alert-warning text-center">
            No properties found matching your filters.
        </div>
    </div>';

    exit();
}

while ($row = $result->fetch_assoc()) {
?>

<div class="col-md-4 col-lg-4 mb-4">

    <div class="card shadow h-100">

        <img
            src="https://picsum.photos/400/250?random=<?php echo (int)$row['id']; ?>"
            class="card-img-top"
            height="220"
            alt="<?php echo htmlspecialchars($row['name']); ?>"
        >

        <div class="card-body">

            <h5 class="card-title">
                <?php echo htmlspecialchars($row['name']); ?>
            </h5>

            <p class="mb-1">
                <strong>City:</strong>
                <?php echo htmlspecialchars($row['city']); ?>
            </p>

            <p class="mb-1">
                <strong>Price:</strong>
                ₹<?php echo htmlspecialchars($row['price']); ?>/month
            </p>

            <p class="mb-1">
                <strong>Gender:</strong>
                <?php echo htmlspecialchars($row['gender']); ?>
            </p>

            <p class="mb-3">
                ⭐ <?php echo htmlspecialchars($row['rating']); ?>
            </p>

            <a
                href="property.php?id=<?php echo (int)$row['id']; ?>"
                class="btn btn-primary w-100"
            >
                View Details
            </a>

        </div>

    </div>

</div>

<?php
}
?>