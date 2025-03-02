<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Follow/Unfollow System</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Welcome!</h1>
    <a href="logout.php">Logout</a>
    <h2>Users</h2>
    <div id="users-list">
        <!-- Users will be dynamically loaded here -->
    </div>

    <script>
        $(document).ready(function() {
            // Load users
            $.ajax({
                url: 'get_users.php',
                method: 'GET',
                success: function(response) {
                    $('#users-list').html(response);
                }
            });

            // Follow/Unfollow action
            $(document).on('click', '.follow-btn', function() {
                var followee_id = $(this).data('id');
                var action = $(this).hasClass('follow') ? 'follow' : 'unfollow';

                $.ajax({
                    url: action + '.php',
                    method: 'POST',
                    data: { followee_id: followee_id },
                    success: function(response) {
                        alert(response);
                        location.reload(); // Refresh the page to update buttons
                    }
                });
            });
        });
    </script>
</body>
</html>