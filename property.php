<?php

session_start();

include("includes/db.php");
include("includes/header.php");

if (!isset($_GET['id'])) {
    die("Property not found.");
}

$id = (int)$_GET['id'];


// Get property
$stmt = $conn->prepare("SELECT * FROM properties WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Property not found.");
}

$property = $result->fetch_assoc();


// Get amenities for this property
$amenityStmt = $conn->prepare("
    SELECT a.name
    FROM amenities a
    INNER JOIN property_amenities pa
        ON a.id = pa.amenity_id
    WHERE pa.property_id = ?
");

$amenityStmt->bind_param("i", $id);
$amenityStmt->execute();

$amenityResult = $amenityStmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?php echo htmlspecialchars($property['name']); ?>
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="css/style.css"
    >

</head>

<body>

<div class="container py-5">

    <!-- BACK BUTTON -->

    <a
        href="index.php"
        class="btn btn-secondary mb-4"
        onclick="history.back(); return false;"
    >
        ← Back to Properties
    </a>


    <div class="row g-4">
        <div class="col-lg-7">

            <div class="card shadow">

                <!-- Main Image -->

                <img
                id="mainPropertyImage"
                src="<?php echo htmlspecialchars($property['image']); ?>"
                class="card-img-top"
                style="height:420px; object-fit:cover;"
                alt="<?php echo htmlspecialchars($property['name']); ?>"
                onerror="this.onerror=null; this.src='https://picsum.photos/900/500?random=<?php echo $property['id']; ?>';"
                >
                <div class="card-body">

                    <div class="row g-2">

                        <div class="col-4">

                            <img
                                src="https://picsum.photos/300/180?random=<?php echo $property['id']; ?>1"
                                class="img-fluid rounded gallery-thumb"
                                style="height:100px; width:100%; object-fit:cover; cursor:pointer;"
                                onclick="changeMainImage(this.src)"
                                alt="Property image"
                            >

                        </div>


                        <div class="col-4">

                            <img
                                src="https://picsum.photos/300/180?random=<?php echo $property['id']; ?>2"
                                class="img-fluid rounded gallery-thumb"
                                style="height:100px; width:100%; object-fit:cover; cursor:pointer;"
                                onclick="changeMainImage(this.src)"
                                alt="Property image"
                            >

                        </div>


                        <div class="col-4">
                            <img
                                src="https://picsum.photos/300/180?random=<?php echo $property['id']; ?>3"
                                class="img-fluid rounded gallery-thumb"
                                style="height:100px; width:100%; object-fit:cover; cursor:pointer;"
                                onclick="changeMainImage(this.src)"
                                alt="Property image"
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card shadow h-100">
                <div class="card-body">
                    <h2 class="mb-3">
                        <?php
                        echo htmlspecialchars($property['name']);
                        ?>
                    </h2>
                    <p class="fs-5">
                        📍
                        <?php
                        echo htmlspecialchars($property['city']);
                        ?>
                    </p>
                    <h4 class="text-primary">
                        ₹<?php
                        echo htmlspecialchars($property['price']);
                        ?>
                        <small class="text-muted">
                            /month
                        </small>
                    </h4>
                    <p>
                        👤
                        <strong>Gender:</strong>
                        <?php
                        echo htmlspecialchars($property['gender']);
                        ?>
                    </p>
                    <div class="mb-3">
                        <strong>Rating:</strong>
                        <span class="text-warning fs-5">
                            <?php

                            $rating = (float)$property['rating'];

                            $fullStars = floor($rating);

                            for ($i = 1; $i <= $fullStars; $i++) {
                                echo "★";
                            }
                            ?>
                        </span>
                        <span>
                            <?php
                            echo number_format($rating, 1);
                            ?>/5
                        </span>
                    </div>
                    <hr>
                    <h5>
                        About this Property
                    </h5>

                    <p class="text-muted">

                        <?php
                        echo nl2br(
                            htmlspecialchars($property['description'])
                        );
                        ?>
                    </p>
                    <h5 class="mt-4">
                        Amenities
                    </h5>
                    <div class="row">
                        <?php
                        if ($amenityResult->num_rows > 0) {
                            while ($amenity = $amenityResult->fetch_assoc()) {
                        ?>
                                <div class="col-6 mb-2">
                                    <div class="border rounded p-2">
                                        ✅
                                        <?php
                                        echo htmlspecialchars(
                                            $amenity['name']
                                        );
                                        ?>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                        ?>
                            <div class="col-12">
                                <p class="text-muted">
                                    Amenities information not available.
                                </p>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <button
                        id="interestBtn"
                        class="btn btn-success btn-lg w-100 mt-4"
                        onclick="interested(<?php echo $property['id']; ?>, this)"
                    >
                        ❤️ I'm Interested
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function changeMainImage(imageSource) {
    document.getElementById(
        "mainPropertyImage"
    ).src = imageSource;
}
</script>
<script src="js/script.js"></script>
</body>
</html>
<?php include("includes/footer.php"); ?>