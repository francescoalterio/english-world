const $form = document.querySelector("form");

const showError = (message) => {
  const $error = document.getElementById("error");
  $error.style.display = "block";
  $error.innerText = message;
};

$form.addEventListener("submit", (event) => {
  const formData = new FormData(event.target);
  if (
    !formData.has("username") ||
    !formData.has("email") ||
    !formData.has("password") ||
    !formData.has("repeat-password")
  ) {
    event.preventDefault();
    showError(
      "The username, email, password and repeat-password fields are required"
    );
  }

  const username = formData.get("username");
  const email = formData.get("email");
  const password = formData.get("password");
  const repeatPassword = formData.get("repeat-password");

  const emailRegex =
    /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

  if (username.length < 3 || username.length > 16) {
    event.preventDefault();
    showError("Username must be between 3 and 16 characters");
  } else if (!email.match(emailRegex)) {
    event.preventDefault();
    showError("The email is invalid or in use");
  } else if (password.length < 6 || password.length > 12) {
    event.preventDefault();
    showError("The password must be between 6 and 12 characters");
  } else if (password !== repeatPassword) {
    event.preventDefault();
    showError("Passwords do not match");
  }
});
