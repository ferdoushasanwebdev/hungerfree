<?php
include("./includes/header.php");
include("./class/class.category.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$catObj = new Category();
$categories = $catObj->fetchCategories();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($_POST['formtype'] === "insertCategory") {
        $name = $_POST['cat_name'];
        $duration = $_POST['cat_duration'];

        if (isset($name) && isset($duration)) {
            $catObj->insertCategories($name, $duration);
            $categories = $catObj->fetchCategories();
        }
    } elseif ($_POST['formtype'] === "editCategory") {
        $catId = $_POST['cat_id'];
        $name = $_POST['cat_name'];
        $duration = $_POST['cat_duration'];

        if (isset($catId) && isset($name) && isset($duration)) {
            $catObj->updateCategory($catId, $name, $duration);
            $categories = $catObj->fetchCategories();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['delete']) && $_GET['delete'] == 1) {
        $catObj->deleteCategory($_GET['cat_id']);
        $categories = $catObj->fetchCategories();
    }
}
?>

<?php include("./includes/sidebar.php"); ?>

<div class="main-content">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="text-center">Insert Category</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="formtype" value="insertCategory" />
                            <div class="mb-3">
                                <label for="categoryName" class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="categoryName" name="cat_name" placeholder="Enter category name" required>
                            </div>
                            <div class="mb-3">
                                <label for="freshnessTime" class="form-label">Food Freshness Time (in hours)</label>
                                <input type="number" class="form-control" id="freshnessTime" name="cat_duration" placeholder="Enter freshness time" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Add Category</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow">
                    <div class="card-header bg-secondary text-white">
                        <h5>Category List</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Category Name</th>
                                    <th>Freshness Time (Hours)</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($categories)) {
                                    $count = 1;
                                    foreach ($categories as $category) { ?>
                                        <tr>
                                            <td><?php echo ($count++) ?></td>
                                            <td><?php echo ($category['cat_name']) ?></td>
                                            <td><?php echo ($category['cat_duration']) ?></td>
                                            <td>
                                                <button
                                                    class="btn btn-warning btn-sm edit-button"
                                                    data-id="<?php echo $category['cat_id']; ?>"
                                                    data-name="<?php echo $category['cat_name']; ?>"
                                                    data-duration="<?php echo $category['cat_duration']; ?>">Edit</button>
                                                <a class="btn btn-danger btn-sm" href="?delete=1&cat_id=<?php echo ($category['cat_id']); ?>">Delete</a>
                                            </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td class="text-center" colspan="4">
                                            <h6>No category found</h6>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="editCategory" class="card mt-4" style="display: none;">
                    <div class="card-header bg-warning text-white">
                        <h5>Edit Category</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="formtype" value="editCategory" />
                            <input type="hidden" id="editCatId" name="cat_id" />
                            <div class="mb-3">
                                <label for="editCategoryName" class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="editCategoryName" name="cat_name" placeholder="Enter category name" required>
                            </div>
                            <div class="mb-3">
                                <label for="editFreshnessTime" class="form-label">Food Freshness Time (in hours)</label>
                                <input type="number" class="form-control" id="editFreshnessTime" name="cat_duration" placeholder="Enter freshness time" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    const editButtons = document.querySelectorAll(".edit-button");
    const editForm = document.getElementById("editCategory");

    editButtons.forEach(button => {
        button.addEventListener("click", function() {
            const categoryId = this.getAttribute("data-id");
            const categoryName = this.getAttribute("data-name");
            const categoryDuration = this.getAttribute("data-duration");

            document.getElementById("editCatId").value = categoryId;
            document.getElementById("editCategoryName").value = categoryName;
            document.getElementById("editFreshnessTime").value = categoryDuration;

            editForm.style.display = "block";

            editForm.scrollIntoView({
                behavior: "smooth"
            });
        });
    });
</script>

<?php include("./includes/footer.php"); ?>