<?php
include("./includes/header.php");

if (!isset($_SESSION['user_id'])) {
  header("Location: index.php");
  exit();
}
?>
<?php include("./includes/sidebar.php") ?>

<div class="main-content">
  <div class="container-fluid">
    <div
      class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Dashboard</h1>
    </div>

    <div class="row">
      <?php if ($_SESSION['user_role'] == "admin") {
      ?><div class="col-md-4 mb-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Total Food Donors</h5>
              <p class="card-text display-4" id="totalDonors">120</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Total Food Donations</h5>
              <p class="card-text display-4" id="totalDonations">350</p>
            </div>
          </div>
        </div><?php
            } ?>
      <?php if ($_SESSION['user_role'] == "donor") {
      ?>
        <div class="col-md-4 mb-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Total Donated Foods</h5>
              <p class="card-text display-4" id="totalDonations">350</p>
            </div>
          </div>
        </div><?php
            } ?>
      <?php if ($_SESSION['user_role'] == "recipient") {
      ?>
        <div class="col-md-4 mb-4">
          <div class="border border-secondary border-1 rounded-1 py-3 text-center">
            <a href="discoverposts.php" class="text-decoration-none text-secondary">Discover Available Foods</a>
          </div>
        </div><?php
            } ?>
    </div>

    <div class="row">
      <div class="col-md-6 mb-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Food Donations by Area</h5>
            <canvas id="areaChart"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-6 mb-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">
              Food Donations - Last Month vs Last Week
            </h5>
            <canvas id="timeChart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const areaCtx = document.getElementById("areaChart").getContext("2d");
  new Chart(areaCtx, {
    type: "bar",
    data: {
      labels: ["Area 1", "Area 2", "Area 3", "Area 4", "Area 5"],
      datasets: [{
        label: "Food Donations",
        data: [50, 80, 60, 90, 70],
        backgroundColor: "rgba(54, 162, 235, 0.6)",
        borderColor: "rgba(54, 162, 235, 1)",
        borderWidth: 1,
      }, ],
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    },
  });

  const timeCtx = document.getElementById("timeChart").getContext("2d");
  new Chart(timeCtx, {
    type: "line",
    data: {
      labels: ["Week 1", "Week 2", "Week 3", "Week 4"],
      datasets: [{
          label: "Last Month",
          data: [30, 45, 50, 40],
          backgroundColor: "rgba(75, 192, 192, 0.2)",
          borderColor: "rgba(75, 192, 192, 1)",
          borderWidth: 1,
        },
        {
          label: "Last Week",
          data: [12, 20, 15, 25],
          backgroundColor: "rgba(255, 159, 64, 0.2)",
          borderColor: "rgba(255, 159, 64, 1)",
          borderWidth: 1,
        },
      ],
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    },
  });
</script>

<?php include("./includes/footer.php") ?>