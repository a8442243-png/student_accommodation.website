function interested(propertyId, button = null) {

    if (!button) {
        button = document.getElementById("interestBtn");
    }

    button.disabled = true;
    button.innerHTML = "⏳ Please wait...";

    fetch("ajax_interest.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "property_id=" + propertyId
    })

    .then(response => response.text())

    .then(data => {

        data = data.trim();

        if (data === "login") {

            window.location = "login.php";

        }

        else if (data === "added") {

            button.innerHTML = "💔 Remove from Shortlist";

            button.classList.remove("btn-success");
            button.classList.add("btn-danger");

            button.disabled = false;
        }

        else if (data === "removed") {

            button.innerHTML = "❤️ I'm Interested";

            button.classList.remove("btn-danger");
            button.classList.add("btn-success");

            button.disabled = false;
        }

        else {

            alert("Something went wrong.");
            button.disabled = false;
        }

    })

    .catch(error => {

        console.error(error);

        alert("Network error. Please try again.");

        button.disabled = false;
    });
}
function filterProperties() {

    let city = document.getElementById("cityFilter").value;
    let budget = document.getElementById("budgetFilter").value;
    let gender = document.getElementById("genderFilter").value;

    let loading = document.getElementById("loading");
    let propertyList = document.getElementById("propertyList");

    loading.style.display = "block";

    fetch("ajax_filter.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body:
            "city=" + encodeURIComponent(city) +
            "&budget=" + encodeURIComponent(budget) +
            "&gender=" + encodeURIComponent(gender)
    })
    .then(response => response.text())
    .then(data => {

        propertyList.innerHTML = data;

        loading.style.display = "none";

    })
    .catch(error => {

        console.error(error);

        propertyList.innerHTML = `
            <div class="col-12">
                <div class="alert alert-danger text-center">
                    Something went wrong while loading properties.
                </div>
            </div>
        `;

        loading.style.display = "none";
    });
}


function resetFilters() {

    document.getElementById("cityFilter").value = "";
    document.getElementById("budgetFilter").value = "";
    document.getElementById("genderFilter").value = "";

    filterProperties();
}

function removeFromShortlist(propertyId, button) {

    button.disabled = true;
    button.innerHTML = "⏳ Removing...";

    fetch("ajax_interest.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "property_id=" + propertyId
    })

    .then(response => response.text())

    .then(data => {

        data = data.trim();

        if (data === "removed") {

            const card = document.getElementById(
                "property-" + propertyId
            );

            if (card) {
                card.remove();
            }

            // If no cards remain, show message
            const container =
                document.getElementById("shortlistContainer");

            if (
                container &&
                container.querySelector(".property-card") === null
            ) {
                container.innerHTML = `
                    <div class="col-12">
                        <div class="alert alert-info">
                            You haven't shortlisted any property yet.
                        </div>
                    </div>
                `;
            }

        }

        else if (data === "login") {

            window.location = "login.php";

        }

        else {

            alert("Unable to remove property.");
            button.disabled = false;
            button.innerHTML = "💔 Remove";
        }

    })

    .catch(error => {

        console.error(error);

        alert("Network error. Please try again.");

        button.disabled = false;
        button.innerHTML = "💔 Remove";
    });
}
// ===============================
// SAVE FILTERS WHEN APPLY IS CLICKED
// ===============================

document.addEventListener("DOMContentLoaded", function () {

    const city = document.getElementById("cityFilter");
    const budget = document.getElementById("budgetFilter");
    const gender = document.getElementById("genderFilter");

    const applyBtn = document.querySelector(
        'button[onclick="filterProperties()"]'
    );

    const resetBtn = document.querySelector(
        'button[onclick="resetFilters()"]'
    );

    // Restore previously selected filters
    const savedFilters = sessionStorage.getItem("pgFilters");

    if (savedFilters && city && budget && gender) {

        const filters = JSON.parse(savedFilters);

        city.value = filters.city || "";
        budget.value = filters.budget || "";
        gender.value = filters.gender || "";

        // Apply saved filters again
        if (typeof filterProperties === "function") {
            filterProperties();
        }
    }
    if (applyBtn) {

        applyBtn.addEventListener("click", function () {

            sessionStorage.setItem(
                "pgFilters",
                JSON.stringify({
                    city: city.value,
                    budget: budget.value,
                    gender: gender.value
                })
            );

        });

    }

    if (resetBtn) {

        resetBtn.addEventListener("click", function () {
            sessionStorage.removeItem("pgFilters");
        });

    }

});