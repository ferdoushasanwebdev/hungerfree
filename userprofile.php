<?php
include("./includes/header.php");
include("./class/class.user.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
}

$userObj = new User();
$user = $userObj->fetchUserById($_GET['id'])[0];
?>
<?php include("./includes/sidebar.php") ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
    <h1 class="mt-4">User Profile</h1>
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-picture-container border border-1 border-dark">
                        <img src="<?php echo ('./uploads/photo/' . $user['user_photo']) ?>" alt="Profile Picture" class="img-fluid mb-3" style="height: 100%; width: 100%;" />
                    </div>
                </div>
                <div class="col-md-8">
                    <h4>Name: <?php echo ($user['user_name']) ?></h4>
                    <p><strong>Phone:</strong> <?php echo ($user['user_phone']) ?></p>
                    <p><strong>Email:</strong> <?php echo ($user['user_email']) ?></p>
                    <p><strong>Address:</strong> <?php echo ($user['user_address']) ?></p>
                    <p><strong>District:</strong> <?php echo ($user['user_district']) ?></p>
                    <p><strong>Division:</strong> <?php echo ($user['user_division']) ?></p>
                    <p><strong>Role:</strong> <?php echo ($user['user_role']) ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5>Certificate/NID Image</h5>
            <img src="<?php echo ('./uploads/certificate/' . $user['user_file']) ?>" alt="Certificate or NID" class="img-fluid">
        </div>
    </div>
</main>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>