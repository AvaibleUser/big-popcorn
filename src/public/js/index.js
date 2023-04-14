const searchInput = document.getElementById("search-publication");
const registerBtn = document.getElementById("register");
const sessionBtn = document.getElementById("session");
const toPublishBtn = document.getElementById("publish");

const sessionData = localStorage.getItem("session");

if (sessionData) {
  registerBtn.remove();
  sessionBtn.children[0].innerText = `Cerrar Sesion`;

  sessionBtn.addEventListener("click", () => {
    localStorage.removeItem("session");
    location.href = "/dashboard.html";
  });

  toPublishBtn.addEventListener("click", () => {
    location.href = "/publish.html";
  });
} else {
  toPublishBtn.remove();
  sessionBtn.children[0].innerText = `Iniciar Sesion`;

  sessionBtn.addEventListener("click", () => {
    location.href = "/login.html";
  });

  registerBtn.addEventListener("click", () => {
    location.href = "/sign-up.html";
  });
}

searchInput.addEventListener("keypress", async (event) => {
  if (event.key !== "Enter") {
    return;
  }
  const title = searchInput.value;

  location.href = `/publications/search/${title}`;
});
