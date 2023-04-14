const nameInput = document.getElementById("name");
const lastnameInput = document.getElementById("lastname");
const emailInput = document.getElementById("email");
const passwordInput = document.getElementById("password");
const signupBtn = document.getElementById("signup");

localStorage.removeItem("session");

signupBtn.addEventListener("click", async () => {
  const name = nameInput.value;
  const lastname = lastnameInput.value;
  const email = emailInput.value;
  const password = passwordInput.value;

  try {
    const response = await fetch("/users/sign-up", {
      method: "POST",
      body: JSON.stringify({ name, lastname, email, password }),
      headers: {
        "Content-Type": "application/json",
      },
    });
    const data = await response.json();

    localStorage.setItem("session", JSON.stringify(data));
    location.href = "/dashboard.html"
  } catch (error) {
    alert("Ocurrio un error creando su credenciales, compruebe los datos");
  }
});
