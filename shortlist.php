<?php
session_start();
include("includes/db.php");
include("includes/header.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user_id'];

$sql = "SELECT properties.*
        FROM interested_users
        JOIN properties
        ON interested_users.property_id = properties.id
        WHERE interested_users.user_id = $user";

$result = $conn->query($sql);
?>

<div class="container mt-5">

    <h2 class="mb-4">❤️ My Shortlisted Properties</h2>

    <div class="row" id="shortlistContainer">

        <?php if ($result->num_rows == 0) { ?>

            <div class="col-12">
                <div class="alert alert-info text-center">
                    No properties shortlisted yet.
                </div>
            </div>

        <?php } ?>

        <?php while ($row = $result->fetch_assoc()) { ?>

            <div class="col-md-4 mb-4" id="property-<?php echo $row['id']; ?>">

                <div class="card shadow h-100">

                    <img
                        src="https://picsum.photos/400/250?random=<?php echo $row['id']; ?>"
                        class="card-img-top"
                        alt="Property"
                    >

                    <div class="card-body">

                        <h5 class="card-title">
                            <?php echo htmlspecialchars($row['name']); ?>
                        </h5>

                        <p>
                            <strong>City:</strong>
                            <?php echo htmlspecialchars($row['city']); ?>
                        </p>

                        <p>
                            <strong>Price:</strong>
                            ₹<?php echo htmlspecialchars($row['price']); ?>/month
                        </p>

                        <p>
                            <strong>Gender:</strong>
                            <?php echo htmlspecialchars($row['gender']); ?>
                        </p>

                        <p>
                            ⭐ <?php echo htmlspecialchars($row['rating']); ?>
                        </p>

                        <div class="d-flex gap-2">

                            <a
                                href="property.php?id=<?php echo $row['id']; ?>"
                                class="btn btn-primary"
                            >
                                View
                            </a>

                            <button
                                type="button"
                                class="btn btn-danger"
                                onclick="removeShortlist(<?php echo $row['id']; ?>)"
                            >
                                🗑 Remove
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        <?php } ?>

    </div>

</div>

<script>

function removeShortlist(propertyId) {

    fetch("ajax_interest.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "property_id=" + propertyId
    })

    .then(response => response.text())

    .then(data => {

        if (data.trim() === "removed") {

            const card = document.getElementById("property-" + propertyId);

            if (card) {
                card.remove();
            }

            const remaining = document.querySelectorAll(
                "#shortlistContainer > div[id^='property-']"
            );

            if (remaining.length === 0) {

                document.getElementById("shortlistContainer").innerHTML =
                    '<div class="col-12">' +
                    '<div class="alert alert-info text-center">' +
                    'No properties shortlisted yet.' +
                    '</div>' +
                    '</div>';

            }

        } else if (data.trim() === "login") {

            window.location = "login.php";

        } else {

            alert("Unable to remove property.");

        }

    })

    .catch(error => {

        console.error(error);
        alert("Something went wrong.");

    });

}

</script>

<?php include("includes/footer.php"); ?>