<?php
require_once "init.php";
require_once "helpers.php";
require_once "sql-queries.php";

$is_auth = rand(0, 1);
$user_name = 'root'; // укажите здесь ваше имя
$page_title = 'Readme: Публикация';

$post_id = isset($_GET['post_id']) ? $_GET['post_id'] : null;

$post = get_post_id($connection,$post_id)[0];

if(!$post) {
    header("HTTP/1.0 404 Not Found");
    $error_msg = 'Упс, ошибка 404. Публикация не существует: ' . mysqli_error($connection);
    die($error_msg);
    }

$post_content = include_template("post/{$post['content_icon_name']}.php", ['post' => $post]);
$posts_count = get_user_posts_count($connection, $post['author_id']);
$page_content = include_template('post/post-show.php', [
    'post_content' => $post_content,
    'post' => $post,
    'user_posts_count' => $posts_count[0],
    ]);

$layout_content = include_template('layout.php',[
   'page_content' => $page_content,
   'is_auth' => $is_auth,
   'user_name' => $user_name,
   'title' => $page_title,
]);
print($layout_content);
