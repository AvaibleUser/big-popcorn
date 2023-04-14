const emailInput = document.getElementById("email");
const passwordInput = document.getElementById("password");
const loginBtn = document.getElementById("login");

localStorage.removeItem("session");

loginBtn.addEventListener("click", async () => {
  const email = emailInput.value;
  const password = passwordInput.value;

  try {
    const response = await fetch("/users/login", {
      method: "POST",
      body: JSON.stringify({ email, password }),
      headers: {
        "Content-Type": "application/json",
      },
    });
    const data = await response.json();

    localStorage.setItem("session", JSON.stringify(data));
    location.href = "/dashboard.html"
  } catch (error) {
    alert("Ocurrio un error iniciando sesion, compruebe los datos");
  }
});
