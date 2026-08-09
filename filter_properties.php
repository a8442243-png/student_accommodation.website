<?php

include("includes/db.php");
$city   = isset($_POST['city']) ? trim($_POST['city']) : '';
$budget = isset($_POST['budget']) ? trim($_POST['budget']) : '';
$gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';

$sql = "SELECT * FROM properties WHERE 1=1";

if ($city !== '') {
    $citySafe = $conn->real_escape_string($city);
    $sql .= " AND city = '$citySafe'";
}

if ($budget !== '' && is_numeric($budget)) {
    $budgetValue = (int)$budget;
    $sql .= " AND price <= $budgetValue";
}

if ($gender !== '') {

    $genderSafe = $conn->real_escape_string($gender);

    $sql .= " AND (gender = '$genderSafe' OR gender = 'Any')";
}

$result = $conn->query($sql);

if ($result->num_rows == 0) {
?>

    <div class="col-12">
        <div class="alert alert-warning text-center">
            😔 No properties found for your requirement.
        </div>
    </div>

<?php
    exit;
}

while ($row = $result->fetch_assoc()) {
?>

    <div class="col-md-3 mb-4">

        <div class="card shadow h-100">

            <img
                src="https://picsum.photos/400/250?random=<?php echo $row['id']; ?>"
                class="card-img-top"
                height="220"
                alt="Property"
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

                <p>
                    ⭐ <?php echo htmlspecialchars($row['rating']); ?>
                </p>

                <a
                    href="property.php?id=<?php echo $row['id']; ?>"
                    class="btn btn-primary w-100"
                </a>

            </div>

        </div>

    </div>

<?php
}
?>