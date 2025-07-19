function login() {
  const username = document.getElementById("username").value.trim();
  const password = document.getElementById("password").value.trim();
  const loginMsg = document.getElementById("loginMsg");

  if (username === "admin" && password === "password1234") {
    localStorage.setItem("adminLoggedIn", "true");
    loginMsg.innerText = "";
    showGallery();
  } else {
    loginMsg.innerText = "❌ Invalid username or password!";
  }
}

function showGallery() {
  document.getElementById("loginBox").style.display = "none";
  document.getElementById("galleryBox").style.display = "block";

  fetch("gallery.php")
    .then(res => res.json())
    .then(images => {
      const gallery = document.getElementById("gallery");
      gallery.innerHTML = "";
      images.forEach(img => {
        const container = document.createElement("div");
        container.style.position = "relative";

        const imgTag = document.createElement("img");
        imgTag.src = "uploads/" + img;
        imgTag.style.width = "100%";
        imgTag.style.borderRadius = "10px";
        imgTag.style.objectFit = "cover";
        imgTag.style.boxShadow = "0 4px 10px rgba(0,0,0,0.1)";
        container.appendChild(imgTag);

        const delBtn = document.createElement("button");
        delBtn.textContent = "Delete";
        delBtn.style.position = "absolute";
        delBtn.style.top = "8px";
        delBtn.style.right = "8px";
        delBtn.style.background = "#dc3545";
        delBtn.style.color = "white";
        delBtn.style.border = "none";
        delBtn.style.padding = "5px 10px";
        delBtn.style.borderRadius = "5px";
        delBtn.style.cursor = "pointer";
        delBtn.onclick = () => deleteImage(img);
        container.appendChild(delBtn);

        gallery.appendChild(container);
      });
    });
}

function deleteImage(filename) {
  if (!confirm(`Are you sure you want to delete "${filename}"?`)) return;

  fetch("delete.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `filename=${encodeURIComponent(filename)}`,
  })
    .then(res => res.text())
    .then(msg => {
      alert(msg);
      showGallery(); // refresh gallery after delete
    })
    .catch(() => alert("Delete failed!"));
}

function logout() {
  localStorage.removeItem("adminLoggedIn");
  document.getElementById("galleryBox").style.display = "none";
  document.getElementById("loginBox").style.display = "block";
}

window.onload = () => {
  if (localStorage.getItem("adminLoggedIn") === "true") {
    showGallery();
  }
};