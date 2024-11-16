<?php
session_start();
if (isset($_SESSION['user_id'])) {
  header("Location: dashboard.php");
  exit;
}

include_once("./class/class.user.php");
$userObj = new User();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if ($_POST['formtype'] == "register") {
    $name = $_POST['user_name'];
    $phone = $_POST['user_phone'];
    $email = $_POST['user_email'];
    $password = $_POST['user_password'];
    $file = $_FILES['user_file'];
    $role = $_POST['user_role'];

    if (isset($name) && isset($phone) && isset($email) && isset($password) && isset($file) && isset($role)) {
      $userObj->signUp($name, $phone, $email, $password, $file, $role);
    }
  }

  if ($_POST['formtype'] == "login") {
    $phone = $_POST['user_phone'];
    $password = $_POST['user_password'];

    if (isset($phone) && isset($password)) {
      $userObj->login($phone, $password);
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HungerFree Community Platform</title>
  <link rel="stylesheet" href="./assets/css/style.css" />
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet" />
</head>

<body>
  <section id="cover-img">
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container">
        <a class="navbar-brand" href="./index.php">HungerFree Community Platform</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" href="./index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact Us</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <section class="container">
      <div class="row justify-content-lg-end justify-content-center">
        <div class="col-lg-5 col-md-8 col-10 login-form text-light">
          <h4 id="formTitle" class="text-center">Login</h4>
          <form id="login-form" method="POST" action="#">
            <input type="hidden" name="formtype" value="login" />
            <div class="my-2">
              <label for="phone">Phone Number</label>
              <input
                type="phone"
                class="form-control"
                id="phone"
                name="user_phone"
                placeholder="Enter Phone Number" />
            </div>
            <div class="my-2">
              <label for="password">Password</label>
              <input
                type="password"
                class="form-control"
                id="password"
                name="user_password"
                placeholder="Password" />
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
            <p class="text-center m-3">
              Don't have an account?
              <a
                id="createAccountLink"
                href="#"
                class="text-decoration-none text-primary">Sign Up here</a>
            </p>
          </form>
          <form id="register-form" method="POST" action="#" enctype="multipart/form-data" style="display: none">
            <input type="hidden" name="formtype" value="register" />
            <div class="my-2">
              <label for="name">Role</label>
              <select id="role" class="form-control" name="user_role" required>
                <option value="donor">Donor</option>
                <option value="recipient">Recipient</option>
                <option value="admin">Admin</option>
              </select>
            </div>
            <div id="individual-name" class="my-2">
              <label id="namelabel" for="name">Name</label>
              <input
                type="text"
                class="form-control"
                id="name"
                name="user_name"
                placeholder="Enter Name" />
            </div>
            <div class="row my-2">
              <div class="col">
                <label for="email">Email address</label>
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  name="user_email"
                  placeholder="Enter email" />
              </div>
              <div class="col">
                <label for="phone">Phone Number</label>
                <input
                  type="phone"
                  class="form-control"
                  id="phone"
                  name="user_phone"
                  placeholder="Enter Phone Number" />
              </div>
            </div>
            <div class="my-2">
              <label id="certificate" for="photo">Upload Your NID</label>
              <input
                type="file"
                class="form-control"
                name="user_file"
                id="photo" />
            </div>
            <div class="my-2">
              <label for="password">Password</label>
              <input
                type="password"
                class="form-control"
                id="password"
                name="user_password"
                placeholder="Password" />
            </div>
            <button type="submit" class="btn btn-primary w-100">
              Sign Up
            </button>
            <p class="text-center m-3">
              Already have an account?
              <a
                id="loginFormLink"
                href="#"
                class="text-decoration-none text-primary">Sign In here</a>
            </p>
          </form>
        </div>
      </div>
    </section>
  </section>

  <script type="text/javascript">
    const formSection = document.getElementsByClassName("login-form")[0];
    formSection.style.marginTop = screen.height * 0.085 + "px";

    const formTitle = document.getElementById("formTitle");
    const loginForm = document.getElementById("login-form");
    const registerForm = document.getElementById("register-form");
    const createAccountLink = document.getElementById("createAccountLink");
    const loginFormLink = document.getElementById("loginFormLink");

    createAccountLink.addEventListener("click", function(e) {
      e.preventDefault();
      formTitle.innerHTML = "Sign Up";
      registerForm.style.display = "block";
      loginForm.style.display = "none";
    });

    loginFormLink.addEventListener("click", function(e) {
      e.preventDefault();
      formTitle.innerHTML = "Login";
      loginForm.style.display = "block";
      registerForm.style.display = "none";
    });

    document.getElementById("role").addEventListener("change", function(e) {
      const role = document.getElementById("role").value;
      if (role === "recipient") {
        document.getElementById("namelabel").innerHTML = "Organization Name";
        document.getElementById("certificate").innerHTML = "Upload NGO Certificate";
      } else {
        document.getElementById("namelabel").innerHTML = "Your Name";
        document.getElementById("certificate").innerHTML = "Upload Your NID";
      }
    });
  </script>

  <?php include("./includes/footer.php") ?>