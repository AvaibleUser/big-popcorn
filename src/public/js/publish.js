const categoriesSelect = document.getElementById("categories");
const typeSelect = document.getElementById("type");

const titleInput = document.getElementById("title");
const abstractInput = document.getElementById("abstract");
const contentInput = document.getElementById("content");
const categoriesInput = document.getElementById("categories");
const typeInput = document.getElementById("type");

const publishBtn = document.getElementById("publish-btn");

publishBtn.addEventListener("click", async () => {
  const session = JSON.parse(localStorage.getItem("session"));
  const title = titleInput.value;
  const abstract = abstractInput.value;
  const references = [];
  const type = typeInput.value;
  const authors = [{ name: `${session.name} ${session.lastname}` }];
  const categories = categoriesInput.value;
  const content = btoa(
    String.fromCharCode(
      ...new Uint8Array(await contentInput.files[0].arrayBuffer())
    )
  );
  
  try {
    await fetch("/publications", {
      method: "POST",
      body: JSON.stringify({
        title,
        abstract,
        content,
        authors,
        references,
        categories,
        type,
      }),
      headers: {
        "Content-Type": "application/json",
      },
    });
  } catch (error) {
    alert("No se logro hacer la publicacion, compruebe los datos");
  }
});

(async () => {
  const response = await fetch("/categories/options");
  const data = await response.text();

  categoriesSelect.innerHTML += data;
})();

(async () => {
  const response = await fetch("/types/options");
  const data = await response.text();

  typeSelect.innerHTML += data;
})();
