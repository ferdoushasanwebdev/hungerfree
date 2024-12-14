<?php
include("./class/class.notification.php");

$notObj = new Notification();

$notifications = $notObj->fetchNotificationById($_SESSION['user_id']);
?>

<div class="modal fade" id="notificationsModal" tabindex="-1" aria-labelledby="notificationsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationsModalLabel">Notifications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if (!empty($notifications)) { ?>
                    <ul class="list-group">
                        <?php foreach ($notifications as $notification) { ?>
                            <li class="list-group-item <?php echo ($notification['not_read'] == 0 ? "bg-secondary text-light" : ""); ?>">
                                <?php if ($notification['not_type'] === 'request') {
                                ?><a class="nav-link" href="postdetails.php?post_id=<?php echo ($notification['not_post']); ?>&id=<?php echo ($notification['not_id']); ?>"><strong><?php echo ($notification['sender_name']) ?></strong> has requested on a post.</a><?php
                                                                                                                                                                                                                                                                    } elseif ($notification['not_type'] === 'accept') {
                                                                                                                                                                                                                                                                        ?><a class="nav-link" href="postdetails.php?post_id=<?php echo ($notification['not_post']) ?>"><strong><?php echo ($notification['sender_name']) ?></strong> has accepted your request on a post.</a><?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } ?>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <p>No new notifications!</p>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>