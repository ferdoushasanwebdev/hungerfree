<div class="sidebar px-2">
  <h4 class="text-center"><?php echo ($_SESSION['user_name']) ?></h4>
  <a href="./profile.php">Profile</a>
  <?php if ($_SESSION['user_role'] == "admin") {
  ?>
    <a href="./newusers.php">New Users</a>
    <a href="#">New Posts</a><?php
                            } ?>
  <?php if ($_SESSION['user_role'] == "donor") {
  ?><a href="./createPost.php">Create Post</a>
    <a href="#">My Posts</a><?php
                          } ?>
  <a href="./settings.php">Settings</a>
</div>