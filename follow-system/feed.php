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
    <title>Feed</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .post, .comment {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
        .comment {
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <h1>Feed</h1>
    <a href="logout.php">Logout</a>
    <h2>Create a Post</h2>
    <form id="create-post">
        <textarea name="content" placeholder="What's on your mind?" required></textarea>
        <button type="submit">Post</button>
    </form>
    <h2>Posts</h2>
    <div id="posts-list">
        <!-- Posts will be dynamically loaded here -->
    </div>

    <script>
        $(document).ready(function() {
            // Load posts
            function loadPosts() {
                $.ajax({
                    url: 'get_posts.php',
                    method: 'GET',
                    success: function(response) {
                        $('#posts-list').html(response);
                        loadComments();
                    }
                });
            }

            // Load comments for each post
            function loadComments() {
                $('.comments').each(function() {
                    var postId = $(this).data('post-id');
                    var commentSection = $(this);

                    $.ajax({
                        url: 'get_comments.php?post_id=' + postId,
                        method: 'GET',
                        success: function(response) {
                            commentSection.html(response);
                        }
                    });
                });
            }

            // Create a post
            $('#create-post').on('submit', function(e) {
                e.preventDefault();
                var content = $('textarea[name="content"]').val();

                $.ajax({
                    url: 'create_post.php',
                    method: 'POST',
                    data: { content: content },
                    success: function(response) {
                        alert(response);
                        loadPosts();
                    }
                });
            });

            // Add a comment
            $(document).on('click', '.add-comment', function() {
                var postId = $(this).data('post-id');
                var content = $(this).siblings('.comment-input').val();

                $.ajax({
                    url: 'create_comment.php',
                    method: 'POST',
                    data: { post_id: postId, content: content },
                    success: function(response) {
                        alert(response);
                        loadPosts();
                    }
                });
            });

            // Initial load
            loadPosts();
        });
    </script>
</body>
</html>