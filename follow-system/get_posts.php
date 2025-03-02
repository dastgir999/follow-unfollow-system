<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized");
}

$current_user_id = $_SESSION['user_id'];

// Fetch posts from users the current user is following
$stmt = $pdo->prepare("
    SELECT p.id, p.content, p.created_at, u.username 
    FROM posts p
    JOIN users u ON p.user_id = u.id
    WHERE p.user_id IN (
        SELECT followee_id FROM follows WHERE follower_id = ?
    )
    ORDER BY p.created_at DESC
");
$stmt->execute([$current_user_id]);
$posts = $stmt->fetchAll();

foreach ($posts as $post) {
    echo "<div class='post'>
            <h3>{$post['username']}</h3>
            <p>{$post['content']}</p>
            <small>{$post['created_at']}</small>
            <div class='comments' data-post-id='{$post['id']}'></div>
            <textarea class='comment-input' placeholder='Add a comment'></textarea>
            <button class='add-comment' data-post-id='{$post['id']}'>Comment</button>
          </div>";
}
?>