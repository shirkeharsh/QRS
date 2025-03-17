function filterNumbers(input) {
    input.value = input.value.replace(/\D/g, ""); // Remove any non-digit characters
}

function showYearOptions() {
    var school = document.querySelector('input[name="school"]:checked');
    var yearDiv = document.getElementById("yearOptions");
    if (school) {
        yearDiv.style.display = "block";
    } else {
        yearDiv.style.display = "none";
    }
}

function validateForm() {
    var phone = document.forms["studentForm"]["phone"].value;
    var phonePattern = /^[0-9]{10}$/; // Only 10-digit numbers allowed

    if (!phonePattern.test(phone)) {
        alert("Please enter a valid 10-digit phone number.");
        return false;
    }

    return true;
}
