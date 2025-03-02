<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized");
}

$follower_id = $_SESSION['user_id'];
$followee_id = $_POST['followee_id'];

$stmt = $pdo->prepare("INSERT INTO follows (follower_id, followee_id) VALUES (?, ?)");
if ($stmt->execute([$follower_id, $followee_id])) {
    echo "Followed successfully!";
} else {
    echo "Failed to follow!";
}
?>