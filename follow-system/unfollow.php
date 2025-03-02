<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized");
}

$follower_id = $_SESSION['user_id'];
$followee_id = $_POST['followee_id'];

$stmt = $pdo->prepare("DELETE FROM follows WHERE follower_id = ? AND followee_id = ?");
if ($stmt->execute([$follower_id, $followee_id])) {
    echo "Unfollowed successfully!";
} else {
    echo "Failed to unfollow!";
}
?>