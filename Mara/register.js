document.addEventListener("DOMContentLoaded", function() {
    if(registration-form){
        registration-form.addEventListener("submit", validateForm);
    }
    // Initialize the form with default values
    const form = document.getElementById("registraion-form");
    

   function validateForm(event) {
    let isValid = true;
    const errorMessage = document.getElementById("signupError");
    errorMessage.innerHTML = "";  // Reset error message
  }
    // Full Name validation
    const fullName = document.getElementById("memberName").value;
    if (!fullName || !/^[A-Za-z\s]+$/.test(fullName)) {
        errorMessage.innerHTML += "Full Name must only contain letters and spaces.<br>";
        isValid = false;
    }

    // National ID validation
    const nationalID = document.getElementById("id-no").value;
    if (!nationalID || !/^\d{8,15}$/.test(nationalID)) {
        errorMessage.innerHTML += "National ID must be a valid number (6-15 digits).<br>";
        isValid = false;
    }

    // Email validation
    const email = document.getElementById("email").value;
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!email || !emailRegex.test(email)) {
        errorMessage.innerHTML += "Please enter a valid email address.<br>";
        isValid = false;
    }

    // Password validation
    const password = document.getElementById("password").value;
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    if (!password || !passwordRegex.test(password)) {
        errorMessage.innerHTML += "Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one number, and one special character.<br>";
        isValid = false;
    }

    // Confirm Password validation
    const confirmPassword = document.getElementById("confirmpassword").value;
    if (confirmPassword !== password) {
        errorMessage.innerHTML += "Password and Confirm Password do not match.<br>";
        isValid = false;
    }

    // Date of Birth validation
    const dob = document.getElementById("dob").value;
    if (!dob) {
        errorMessage.innerHTML += "Please select your date of birth.<br>";
        isValid = false;
    }

    // Phone Number validation
    const phone = document.getElementById("phone").value;
    if (phone && !/^\d{10}$/.test(phone)) {
        errorMessage.innerHTML += "Phone number must be 10 digits.<br>";
        isValid = false;
    }

    // Amount validation
    const amount = document.getElementById("amount").value;
    if (amount && amount <= 0) {
        errorMessage.innerHTML += "Amount must be a positive number.<br>";
        isValid = false;
    }

    // Role validation
    const role = document.getElementById("role").value;
    if (!role) {
        errorMessage.innerHTML += "Please select a role.<br>";
        isValid = false;
    }

    // Savings validation
    const savings = document.getElementById("savings").value;
    if (!savings) {
        errorMessage.innerHTML += "Please select your savings frequency.<br>";
        isValid = false;
    }
    //check that all fields are filled
    if(!fullName || !nationalID || !email || !password || !confirmPassword || !dob || !phone || !amount || !role || !savings) {
        errorMessage.innerHTML += "Please fill in all fields.<br>";
        isValid = false;
    }
    else{
        errorMessage.innerHTML = "";  // Clear error message if all fields are filled
    }

    if (!isValid) {
        event.preventDefault();  // Prevent form submission if invalid
    }

    else{
        alert('Registration successful!');
    }
});