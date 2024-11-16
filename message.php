<?php include("./includes/header.php");

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

?>
<section style="height: 100vh;" class="d-flex justify-content-center align-items-center bg-light">
    <div class="card text-center shadow p-4">
        <div class="card-body">
            <h5 class="card-title text-danger">Account Pending Approval</h5>
            <p class="card-text">Your account is not approved yet. Please wait for admin approval.</p>
        </div>
    </div>
</section>
<?php include("./includes/footer.php") ?>