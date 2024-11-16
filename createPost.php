<?php
include("./includes/header.php");
include("./class/class.category.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$catObj = new Category();
$categories = $catObj->fetchCategories();
?>
<?php include("./includes/sidebar.php") ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
    <h1 class="mt-4">Create a New Post</h1>
    <form>
        <div class="row">
            <div class="col">
                <label for="foodName" class="form-label">Food Name</label>
                <input type="text" class="form-control" id="foodName" placeholder="Enter food name">
            </div>
            <div class="col">
                <label for="category" class="form-label">Category</label>
                <select id="category" class="form-control">
                    <option value="1">Rice</option>
                    <option value="1">Fruit</option>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image">
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" placeholder="Enter address">
        </div>
        <div class="mb-3">
            <label for="information" class="form-label">Further Information</label>
            <textarea class="form-control" id="information" rows="4" placeholder="Enter any additional information"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</main>
<?php include("./includes/footer.php") ?>