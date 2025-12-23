fetch("/roomfinder/api/auth/session.php")
  .then(res => res.json())
  .then(data => {
    if (!data.logged_in) {
      window.location.href = "login.html";
    } else {
      document.getElementById("welcome").innerText =
        "Welcome, " + data.username;
    }
  });

function logout() {
  fetch("/roomfinder/api/auth/logout.php")
    .then(() => window.location.href = "login.html");
}
