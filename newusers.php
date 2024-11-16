<?php
include("./includes/header.php");
include("./class/class.user.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$userObj = new User();
$users = $userObj->fetchUnapprovedUsers();

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['reject'])) {
        $userObj->removeUser($_GET['id']);
    }
    if (isset($_GET['accept'])) {
        $userObj->approveUser($_GET['id']);
    }
    $users = $userObj->fetchUnapprovedUsers();
}
?>

<?php include("./includes/sidebar.php") ?>

<main class="main-content col-md-6 col-lg-8 px-md-4">
    <h1 class="mt-1">User List</h1>

    <?php if (isset($users)) {
        foreach ($users as $user) { ?>
            <div class="card user-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title"><?php echo ($user['user_name']) ?></h5>
                        <p class="card-text mb-0"><strong>Phone:</strong> <?php echo ($user['user_phone']) ?></p>
                        <p class="card-text mb-0"><strong>Email:</strong> <?php echo ($user['user_email']) ?></p>
                        <p class="card-text"><strong>Role:</strong> <?php echo ($user['user_role']) ?></p>
                    </div>
                    <div>
                        <img src="<?php echo ('./uploads/certificate/' . $user['user_file']) ?>" alt="Certificate or NID" class="certificate-img" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage('<?php echo ('./uploads/certificate/' . $user['user_file']) ?>')">
                    </div>
                </div>
                <div class="action-buttons">
                    <a href="?id=<?php echo ($user['user_id']) ?>&accept=1" class="btn btn-success">Accept</a>
                    <a href="?id=<?php echo ($user['user_id']) ?>&reject=1" class="btn btn-danger">Reject</a>
                </div>
            </div>
    <?php }
    } ?>
</main>
</div>
</div>

<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Certificate/NID</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Certificate or NID" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="notificationsModal" tabindex="-1" aria-labelledby="notificationsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationsModalLabel">Notifications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <li class="list-group-item">Notification 1</li>
                    <li class="list-group-item">Notification 2</li>
                    <li class="list-group-item">Notification 3</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showImage(src) {
        document.getElementById('modalImage').src = src;
    }
</script>

<?php include("./includes/footer.php") ?>