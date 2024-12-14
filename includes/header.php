<?php
session_start();

if (isset($_SESSION['user_id'])) {
  $userlinks = [
    ['title' => 'Dashboard', 'link' => './dashboard.php'],
    ['title' => 'Notifications', 'link' => '#'],
    ['title' => 'Logout', 'link' => './logout.php']
  ];
} else {
  $userlinks = [
    ['title' => 'Home', 'link' => './index.php'],
    ['title' => 'About Us', 'link' => '#'],
    ['title' => 'Contact Us', 'link' => '#']
  ];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Food Donation Dashboard</title>
  <link rel="stylesheet" href="./assets/css/style.css" />
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">HungerFree Community Platform</a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <?php foreach ($userlinks as $userlink) {
            if ($userlink['title'] == "Notifications") {
          ?>
              <li class="nav-item">
                <a class="nav-link notification-link" href="#" data-bs-toggle="modal" data-bs-target="#notificationsModal">Notifications</a>
              </li>
            <?php
            } else {
            ?>
              <li class="nav-item">
                <a class="nav-link" href=<?php echo $userlink['link'] ?>><?php echo $userlink['title'] ?></a>
              </li>
          <?php
            }
          } ?>
        </ul>
      </div>
    </div>
  </nav>

  <?php include("./includes/notifications.php"); ?>