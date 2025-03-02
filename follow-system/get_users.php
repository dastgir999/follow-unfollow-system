<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized");
}

$current_user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT id, username FROM users WHERE id != ?");
$stmt->execute([$current_user_id]);
$users = $stmt->fetchAll();

foreach ($users as $user) {
    $is_following = $pdo->prepare("SELECT * FROM follows WHERE follower_id = ? AND followee_id = ?");
    $is_following->execute([$current_user_id, $user['id']]);
    $is_following = $is_following->fetch();

    $button_text = $is_following ? 'Unfollow' : 'Follow';
    $button_class = $is_following ? 'unfollow' : 'follow';

    echo "<div>
            <span>{$user['username']}</span>
            <button class='follow-btn {$button_class}' data-id='{$user['id']}'>{$button_text}</button>
          </div>";
}
?>