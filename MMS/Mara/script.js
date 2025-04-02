document.getElementById("signup").addEventListener("submit", function(event) {
  const memberName = document.getElementById("memberName").value.trim();
  const nationalID = document.getElementById("id-no").value.trim();
  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value.trim();
  const dob = document.getElementById("dob").value.trim();
  const phone = document.getElementById("phone").value.trim();

  let amount = document.getElementById("amount").value.trim();
  let errorMessage = document.getElementById("errorMessage");
    let emailInput = document.getElementById("email");
    let passwordInput = document.getElementById("password");

    let isValid = true;

  // Reset error message
  errorMessage.textContent = "";

  // Email Validation
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value)) {
    displayError('email-error', 'Invalid email format.');
    isValid = false;
}

// Password Validation
const passwordStrength = checkPasswordStrength(passwordInput.value);
if (passwordStrength < 3) { // Require at least a "good" password
    displayError('password-error', 'Password must be strong (at least 8 characters, mixed case, numbers, symbols).');
    isValid = false;

  // Validate National ID (should be exactly 6 digits)
  if (nationalID.length !== 6) {
      errorMessage.textContent = "National ID must be exactly 6 digits.";
      event.preventDefault();
      return;
  }

  // Validate phone number (Kenyan format - at least 10 digits)
  let phonePattern = /^07\d{8}$/;
  if (!phone.match(phonePattern)) {
      errorMessage.textContent = "Enter a valid Kenyan phone number (e.g., 0712345678).";
      event.preventDefault();
      return;
  }

  // Validate minimum deposit or withdrawal amount
  if (parseInt(amount) < 200) {
      errorMessage.textContent = "Minimum transaction amount is Ksh 200.";
      event.preventDefault();
      return;
  }

 
}
  // Function to display error messages
  function displayError(elementId, message) {
      document.getElementById(elementId).textContent = message;
  }

  // Function to check password strength
  function checkPasswordStrength(password) {
      let strength = 0;
      if (password.length >= 8) strength++;
      if (/[a-z]/.test(password)) strength++;
      if (/[A-Z]/.test(password)) strength++;
      if (/\d/.test(password)) strength++;
      if (/[^a-zA-Z0-9]/.test(password)) strength++;
      return strength;
  }
   // If all validations pass, show success alert
   alert("Congratulations " + memberName + "! You have successfully registered.");
   event.preventDefault(); // Prevent form submission for demo purpose

    // Clear the form fields    
    
});
