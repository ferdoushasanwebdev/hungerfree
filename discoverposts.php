<?php include("./includes/header.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
}

include("./class/class.post.php");
$postObj = new Post();
$posts = $postObj->fetchPosts();
?>
<style>
    .post-card {
        width: 50%;
        margin-bottom: 20px;
    }

    .post-card img {
        max-width: 100%;
        border-radius: 10px;
        cursor: pointer;
    }

    .profile-pic {
        width: 50px;
        height: 50px;
        margin-right: 10px;
    }

    .filter-section {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 20px;
    }
</style>
<?php include("./includes/sidebar.php") ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
    <h1 class="mt-4">Discover Posts</h1>

    <!-- Filter Section -->
    <div class="filter-section">
        <h5>Filter Posts</h5>
        <form>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="categoryFilter" class="form-label">Food Category</label>
                    <select class="form-select" id="categoryFilter">
                        <option selected>All</option>
                        <option value="Vegetarian">Vegetarian</option>
                        <option value="Non-Vegetarian">Non-Vegetarian</option>
                        <option value="Dessert">Dessert</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="freshnessFilter" class="form-label">Freshness Time</label>
                    <select class="form-select" id="freshnessFilter">
                        <option selected>All</option>
                        <option value="1 Hour">1 Hour</option>
                        <option value="1 Day">1 Day</option>
                        <option value="1 Week">1 Week</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="addressFilter" class="form-label">Address (District)</label>
                    <select class="form-select" id="addressFilter">
                        <option selected>All</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Chittagong">Chittagong</option>
                        <option value="Sylhet">Sylhet</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <input type="radio" name="addressOption" id="withinAddress" value="Within Address">
                    <label for="withinAddress">Posts within my address</label>
                </div>
                <div class="col-md-6">
                    <input type="radio" name="addressOption" id="allPosts" value="All Posts" checked>
                    <label for="allPosts">All posts</label>
                </div>
            </div>
        </form>
    </div>

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

<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Food Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Food Image" class="img-fluid">
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

<?php include("./includes/footer.php"); ?>