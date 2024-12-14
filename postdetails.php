<?php
include("./includes/header.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include("./class/class.post.php");
$postObj = new Post();
$post = $postObj->fetchPostsById($_GET['post_id']);

include("./class/class.request.php");
$reqObj = new Request();
$requests = $reqObj->fetchRequestById($_GET['post_id']);

$notObj = new Notification();
$notObj->updateNotificationStatus($_GET['id']);

?>

<style>
    .profile-pic {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        cursor: pointer;
    }

    .food-image {
        max-width: 100%;
        border-radius: 10px;
        cursor: pointer;
    }

    .post-details {
        margin-top: 20px;
        width: 50%;
    }
</style>

<?php include("./includes/sidebar.php") ?>

<main class="col-md-9 col-lg-10 px-md-4 post-details main-content">
    <div class="card my-3">
        <div class="card-body">
            <div class="d-flex align-items-center mb-4">
                <img src="./uploads/photo/<?php echo ($post[0]['user_photo']); ?>" alt="Profile Picture" class="profile-pic" onclick="showImage('profile-pic.jpg')">
                <div class="ms-3">
                    <h5 class="mb-0"><?php echo ($post[0]['user_name']); ?></h5>
                    <small class="text-muted">Posted on: <?php echo ($post[0]['post_date']); ?></small>
                </div>
            </div>
            <div class="mb-3">
                <img src="./uploads/post/<?php echo ($post[0]['post_photo']); ?>" alt="Food Image" class="img-fluid mb-3" onclick="showImage('./uploads/post/<?php echo ($post[0]['post_photo']) ?>')">
                <h6 class="mb-0"><strong>Food Name: </strong><?php echo ($post[0]['post_food']) ?></h6>
                <p class="mb-0"><strong>Category:</strong> <?php echo ($post[0]['cat_name']); ?></p>
                <p class="mb-0"><strong>Freshness:</strong> <?php echo ($post[0]['cat_duration']); ?> </p>
                <p><strong>Address:</strong> <?php echo ($post[0]['user_address']); ?>, <?php echo ($post[0]['user_district']); ?>, <?php echo ($post[0]['user_division']); ?></p>
                <p><?php echo ($post[0]['post_details']) ?></p>
            </div>
            <div class="mb-3">
                <?php if (isset($requests)) {
                    foreach ($requests as $request) {
                        if ($request['req_user'] == $_SESSION['user_id'] || $request['req_receiver'] == $_SESSION['user_id']) {
                ?>
                            <P><strong><a class="text-decoration-none text-dark" href="userprofile.php?id=<?php echo ($request['req_user']); ?>"><?php echo ($request['req_user'] == $_SESSION['user_id'] ? "You" : $request['user_name']); ?></a></strong><?php echo ($request['req_user'] == $_SESSION['user_id'] ? " have" : " has"); ?> requested. <?php if ($request['req_user'] != $_SESSION['user_id']) {
                                                                                                                                                                                                                                                                                                                                                            if ($request['req_accepted'] == 0) {
                                                                                                                                                                                                                                                                                                                                                        ?><a class="btn btn-primary btn-sm">Accept</a><?php
                                                                                                                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                                                                                                                        ?><span class="btn btn-success btn-sm">Accepted</span><?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                                                                                                                                                                                                                                        } ?></P>
                <?php
                        }
                    }
                } ?>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Image View</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Large Image" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<script>
    function showImage(src) {
        document.getElementById('modalImage').src = src;
        const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
        imageModal.show();
    }
</script>

<?php include("./includes/footer.php") ?>