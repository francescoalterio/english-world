const $form = document.querySelector("form");

const showError = (message) => {
  const $error = document.getElementById("error");
  $error.style.display = "block";
  $error.innerText = message;
};

$form.addEventListener("submit", (event) => {
  const formData = new FormData(event.target);
  if (!formData.has("email") || !formData.has("password")) {
    event.preventDefault();
    showError("The email and password fields are required");
  }

  const email = formData.get("email");
  const password = formData.get("password");

  const emailRegex =
    /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

  if (!email.match(emailRegex)) {
    event.preventDefault();
    showError("The email is invalid or in use");
  } else if (password.length < 6 || password.length > 12) {
    event.preventDefault();
    showError("The password must be between 6 and 12 characters");
  }
});
