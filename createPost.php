<?php
include("./includes/header.php");
include("./class/class.category.php");
include("./class/class.post.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$catObj = new Category();
$categories = $catObj->fetchCategories();

$postObj = new Post();
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $foodName = $_POST['food_name'];
    $categoryId = $_POST['category_id'];
    $information = $_POST['information'];
    $image = $_FILES['image'];

    if (isset($foodName) && isset($categoryId) && isset($information) && isset($image)) {
        $result = $postObj->createPost($_SESSION['user_id'], $foodName, $categoryId, $information, $image);
    }
}
?>

<?php include("./includes/sidebar.php") ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
    <h1 class="mt-4">Create a New Post</h1>
    <form method="POST" action="" enctype="multipart/form-data">
        <?php if (!empty($message)) : ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <div class="row">
            <div class="col">
                <label for="foodName" class="form-label">Food Name</label>
                <input type="text" class="form-control" id="foodName" name="food_name" placeholder="Enter food name" required>
            </div>
            <div class="col">
                <label for="category" class="form-label">Category</label>
                <select id="category" class="form-control" name="category_id" required>
                    <option value="">Select a category</option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo $category['cat_id']; ?>">
                            <?php echo htmlspecialchars($category['cat_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>
        <div class="mb-3">
            <label for="information" class="form-label">Further Information</label>
            <textarea class="form-control" id="information" name="information" rows="4" placeholder="Enter any additional information" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</main>

<?php include("./includes/footer.php") ?>