<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized");
}

$post_id = $_GET['post_id'];

$stmt = $pdo->prepare("
    SELECT c.content, c.created_at, u.username 
    FROM comments c
    JOIN users u ON c.user_id = u.id
    WHERE c.post_id = ?
    ORDER BY c.created_at ASC
");
$stmt->execute([$post_id]);
$comments = $stmt->fetchAll();

foreach ($comments as $comment) {
    echo "<div class='comment'>
            <strong>{$comment['username']}</strong>
            <p>{$comment['content']}</p>
            <small>{$comment['created_at']}</small>
          </div>";
}
?>