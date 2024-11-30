<?php include("./includes/header.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include("./class/class.post.php");
$postObj = new Post();
$posts = $postObj->fetchPostsById($_SESSION['user_id']);
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

    .post-card {
        width: 50%;
        margin-bottom: 20px;
    }
</style>

<?php include("./includes/sidebar.php") ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
    <?php if (isset($posts)) {
        foreach ($posts as $post) {
    ?>
            <div class="card post-card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <img src="./uploads/photo/<?php echo ($post['user_photo']); ?>" alt="Profile Picture" class="profile-pic" style="border-radius: 50%;">
                        <div>
                            <h5 class="card-title mb-0"><?php echo ($post['user_name']); ?></h5>
                            <small class="text-muted">Posted on: <?php echo ($post['post_date']); ?></small>
                        </div>
                    </div>
                    <div>
                        <img src="./uploads/post/<?php echo ($post['post_photo']); ?>" alt="Food Image" class="img-fluid mb-3" onclick="showImage('./uploads/post/<?php echo ($post['post_photo']) ?>')">
                        <h6><strong>Food Name: </strong><?php echo ($post['post_food']) ?></h6>
                        <p><strong>Category:</strong> <?php echo ($post['cat_name']); ?></p>
                        <p><strong>Freshness:</strong> <?php echo ($post['cat_duration']); ?> </p>
                        <p><strong>Address:</strong> <?php echo ($post['user_address']); ?>, <?php echo ($post['user_district']); ?>, <?php echo ($post['user_division']); ?></p>
                        <p><?php echo ($post['post_details']) ?></p>
                        <button class="btn btn-primary">Send Request</button>
                    </div>
                </div>
            </div>
    <?php
        }
    } ?>
</main>
</div>
</div>

<!-- Modal for Viewing Images -->
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

<!-- Notifications Modal -->
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
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    function showImage(src) {
        document.getElementById('modalImage').src = src;
        const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
        imageModal.show();
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>