<?php
include("./includes/header.php");
include("./class/class.history.php");
include("./class/class.user.php");

if (!isset($_SESSION['user_id'])) {
  header("Location: index.php");
  exit();
}

if ($_SESSION['user_role'] == "admin") {
  $histObj = new History();
  $userObj = new User();
  $countDonor = $userObj->countDonor();
  $countDonation = $histObj->countHistory();
}

if ($_SESSION['user_role'] == "donor") {
  $histObj = new History();
  $countDonation = $histObj->countHistoryById($_SESSION['user_id']);
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
              <p class="card-text display-4" id="totalDonors"><?php echo ($countDonor) ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Total Food Donations</h5>
              <p class="card-text display-4" id="totalDonations"><?php echo ($countDonation) ?></p>
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
              <p class="card-text display-4" id="totalDonations"><?php echo ($countDonation) ?></p>
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
  async function fetchDivisionData() {
    try {
      const response = await fetch('./fetchDivisionData.php'); // Replace with the correct path
      const data = await response.json();

      // Extract division names and donation counts
      const labels = data.map(item => item.division);
      const counts = data.map(item => item.donation_count);

      // Render chart with fetched data
      const areaCtx = document.getElementById("areaChart").getContext("2d");
      new Chart(areaCtx, {
        type: "bar",
        data: {
          labels: labels,
          datasets: [{
            label: "Food Donations",
            data: counts,
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
    } catch (error) {
      console.error("Error fetching division data:", error);
    }
  }

  // Call the function when the page loads
  fetchDivisionData();


  async function fetchHistoryData() {
    try {
      const response = await fetch('./fetchHistoryData.php'); // Path to your PHP script
      const data = await response.json();

      // Extract months and history counts
      const labels = data.map(item => item.month);
      const counts = data.map(item => item.history_count);

      // Render the chart
      const timeCtx = document.getElementById("timeChart").getContext("2d");
      new Chart(timeCtx, {
        type: "line",
        data: {
          labels: labels,
          datasets: [{
            label: "Histories by Month",
            data: counts,
            backgroundColor: "rgba(75, 192, 192, 0.2)",
            borderColor: "rgba(75, 192, 192, 1)",
            borderWidth: 1,
          }, ],
        },
        options: {
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                stepSize: 1, // Ensure the y-axis shows integer steps
                callback: function(value) {
                  return Number.isInteger(value) ? value : null; // Show integers only
                },
              },
            },
          },
        },
      });
    } catch (error) {
      console.error("Error fetching history data:", error);
    }
  }

  // Call the function when the page loads
  fetchHistoryData();
</script>

<?php include("./includes/footer.php") ?>