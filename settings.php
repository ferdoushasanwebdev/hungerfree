<?php
include("./includes/header.php");
include("./class/class.user.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
}

$userObj = new User();
$user = $userObj->fetchUserById($_SESSION['user_id'])[0];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['user_name'];
    $email = $_POST['user_email'];
    $address = $_POST['user_address'];
    $division = $_POST['user_division'];
    $district = $_POST['user_district'];
    $newpassword = $_POST['newPassword'];
    $confirmpassword = $_POST['confirmPassword'];

    if (!empty($_FILES['user_photo']['name'])) {
        $photo = $_FILES['user_photo'];
    } else {
        $photo = $user['user_photo'];
    }

    if (!empty($photo)) {
        $userObj->updateUser($_SESSION['user_id'], $name, $email, $address, $district, $division, $newpassword, $confirmpassword, $photo);
        $user = $userObj->fetchUserById($_SESSION['user_id'])[0];
    } else {
        $_SESSION['message'] = "You must add profile photo.";
    }
}
?>

<?php include("./includes/sidebar.php") ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
    <h1 class="mt-4">Settings</h1>
    <form class="form-section py-3" method="POST" action="#" enctype="multipart/form-data">
        <?php if (isset($_SESSION['message'])) {
        ?><h6 class="h6 text-danger"><?php echo ($_SESSION['message']) ?></h6><?php
                                                                            } ?>
        <div class="mb-3">
            <label for="userName" class="form-label">Name</label>
            <input type="text" class="form-control" id="userName" name="user_name" placeholder="Enter your name" value="<?php echo ($user['user_name']) ?>">
        </div>
        <div class="mb-3">
            <label for="userEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="userEmail" name="user_email" placeholder="Enter your email" value="<?php echo ($user['user_email']) ?>">
        </div>
        <div class="mb-3">
            <label for="userAddress" class="form-label">Address</label>
            <input type="text" class="form-control" id="userAddress" name="user_address" placeholder="Enter your address" value="<?php echo ($user['user_address']) ?>">
        </div>
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label for="userDivision" class="form-label">Division</label>
                    <select class="form-select" id="userDivision" name="user_division">
                        <option value="">Select your division</option>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="userDistrict" class="form-label">District</label>
                    <select class="form-select" id="userDistrict" name="user_district">
                        <option value="">Select your district</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="newPassword" class="form-label">New Password</label>
            <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Enter your password">
        </div>
        <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Enter your password">
        </div>
        <div class="mb-3">
            <label for="profilePicture" class="form-label">Profile Picture</label>
            <input type="file" class="form-control" name="user_photo" id="profilePicture">
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</main>

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
    fetch('./assets/jsons/divisions.json')
        .then(response => response.json())
        .then(data => {
            const divisionSelect = document.getElementById('userDivision');
            const districtSelect = document.getElementById('userDistrict');
            const selectedDivision = "<?php echo $user['user_division']; ?>";
            const selectedDistrict = "<?php echo $user['user_district']; ?>";

            data.forEach(division => {
                const option = document.createElement('option');
                option.value = division.Name;
                option.textContent = division.Name;

                if (division.Name === selectedDivision) {
                    option.selected = true;
                }

                divisionSelect.appendChild(option);
            });

            if (selectedDistrict) {
                const index = data.findIndex(item => item.Name == divisionSelect.value);

                data[index].Districts.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district;
                    option.textContent = district;

                    if (district === selectedDistrict) {
                        option.selected = true;
                    }

                    districtSelect.appendChild(option);
                })
            }

            divisionSelect.addEventListener("change", function() {
                const index = data.findIndex(item => item.Name == divisionSelect.value);
                districtSelect.innerHTML = "";

                data[index].Districts.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district;
                    option.textContent = district;

                    if (district === selectedDistrict) {
                        option.selected = true;
                    }

                    districtSelect.appendChild(option);
                })
            });
        })
        .catch(error => console.error('Error fetching divisions:', error));
</script>


<?php include("./includes/footer.php") ?>