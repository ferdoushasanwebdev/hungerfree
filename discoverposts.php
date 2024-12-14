<?php
include("./includes/header.php");
include("./class/class.category.php");
include("./class/class.request.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
}

include("./class/class.post.php");
$postObj = new Post();
$posts = $postObj->fetchPosts();

$catObj = new Category();
$categories = $catObj->fetchCategories();

$reqObj = new Request();

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['request']) && $_GET['request'] == 1) {
        $postId = $_GET['post_id'];
        $receiver = $_GET['receiver'];

        $reqObj->insertRequest($postId, $_SESSION['user_id'], $receiver);
    }
}
?>
<style>
    .post-card {
        display: none;
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

    #noResults {
        display: none;
        text-align: center;
        margin-top: 20px;
        font-weight: bold;
        color: #555;
    }
</style>
<?php include("./includes/sidebar.php") ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
    <h1 class="mt-4">Discover Posts</h1>
    <div class="filter-section">
        <h5>Filter Posts</h5>
        <form>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="categoryFilter" class="form-label">Food Category</label>
                    <select class="form-select" id="categoryFilter">
                        <option value="all" selected>All</option>
                        <?php if (isset($categories)) {
                            foreach ($categories as $category) {
                        ?>
                                <option value="<?php echo ($category['cat_id']) ?>">
                                    <?php echo ($category['cat_name']) ?>
                                </option>
                        <?php
                            }
                        } ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="userDivision" class="form-label">Division</label>
                    <select class="form-select" id="userDivision" name="user_division">
                        <option value="">Select your division</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="userDistrict" class="form-label">District</label>
                    <select class="form-select" id="userDistrict" name="user_district">
                        <option value="">Select your district</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <input type="radio" name="addressOption" id="withinAddress" value="within">
                    <label for="withinAddress">Posts within my address</label>
                </div>
                <div class="col-md-3">
                    <input type="radio" name="addressOption" id="allPosts" value="all" checked>
                    <label for="allPosts">All posts</label>
                </div>
            </div>
        </form>
    </div>

    <div id="noResults">No posts match your filter criteria.</div>

    <?php if (isset($posts)) {
        foreach ($posts as $post) {
    ?>
            <div class="card post-card"
                data-category="<?php echo ($post['cat_id']); ?>"
                data-address="<?php echo ($_SESSION['user_district'] == $post['user_district'] ? 'within' : 'all'); ?>" data-division="<?php echo ($post['user_division']); ?>"
                data-district="<?php echo ($post['user_district']); ?>">
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
                        <?php if ($reqObj->fetchRequestByUserId($post['post_id'], $_SESSION['user_id'])) {
                        ?> <a class="btn btn-outline-primary text-primary">Request Sent</a> <?php
                                                                                        } else {
                                                                                            ?><a href="?request=1&&post_id=<?php echo ($post['post_id']); ?>&&receiver=<?php echo ($post['user_id']); ?>" class="btn btn-primary">Send Request</a><?php
                                                                                                                                                                                                                                                } ?>

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

<script>
    function showImage(src) {
        document.getElementById('modalImage').src = src;
        const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
        imageModal.show();
    }

    fetch('./assets/jsons/divisions.json')
        .then(response => response.json())
        .then(data => {
            const divisionSelect = document.getElementById('userDivision');
            const districtSelect = document.getElementById('userDistrict');

            data.forEach(division => {
                const option = document.createElement('option');
                option.value = division.Name;
                option.textContent = division.Name;
                divisionSelect.appendChild(option);
            });

            divisionSelect.addEventListener("change", function() {
                const selectedDivision = divisionSelect.value;
                districtSelect.innerHTML = '<option value="">Select your district</option>';

                const divisionData = data.find(item => item.Name === selectedDivision);
                if (divisionData) {
                    divisionData.Districts.forEach(district => {
                        const option = document.createElement('option');
                        option.value = district;
                        option.textContent = district;
                        districtSelect.appendChild(option);
                    });
                }
            });
        })
        .catch(error => console.error('Error fetching divisions:', error));

    const categoryFilter = document.getElementById("categoryFilter");
    const addressOptions = document.querySelectorAll("input[name='addressOption']");
    const postCards = document.querySelectorAll(".post-card");
    const noResults = document.getElementById("noResults");

    function filterPosts() {
        const selectedCategory = categoryFilter.value; // Get selected address value
        const selectedAddress = document.querySelector("input[name='addressOption']:checked").value; // Get selected address value
        const selectedDivision = document.getElementById('userDivision').value;
        const selectedDistrict = document.getElementById('userDistrict').value;

        let visibleCount = 0; // Counter to track visible posts

        postCards.forEach(post => {
            const postCategory = post.getAttribute("data-category"); // Get address from data attribute
            const postAddress = post.getAttribute("data-address"); // Get address from data attribute
            const postDivision = post.getAttribute("data-division");
            const postDistrict = post.getAttribute("data-district");

            const matchesCategory = selectedCategory === "all" || postCategory === selectedCategory; // Check if category matches
            const matchesAddress = selectedAddress === "all" || (selectedAddress === "within" && postAddress === "within"); // Check if address matches
            const matchesDivision = !selectedDivision || postDivision === selectedDivision;
            const matchesDistrict = !selectedDistrict || postDistrict === selectedDistrict;
            // Display post if it matches both filters
            if (matchesCategory && matchesAddress && matchesDivision && matchesDistrict) {
                post.style.display = "block";
                visibleCount++;
            } else {
                post.style.display = "none";
            }
        });
        // Show 'No results' message if no posts are visible
        noResults.style.display = visibleCount === 0 ? "block" : "none";
    }

    categoryFilter.addEventListener("change", filterPosts);
    addressOptions.forEach(option => option.addEventListener("change", filterPosts));
    document.getElementById("userDivision").addEventListener("change", filterPosts);
    document.getElementById("userDistrict").addEventListener("change", filterPosts);

    filterPosts();
</script>

<?php include("./includes/footer.php"); ?>