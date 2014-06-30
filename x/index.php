<?php

	define('DEBUG',0);
	require_once('core/core.php');
    require_once('core/systems/_db.php');
	require_once('db/user.php');
	require_once('db/news_post.php');
	require_once('db/server.php');

	$core = new Core();
	$user = new User($core->db);
	$post = new News_post($core->db);
	$server = new Server($core->db);

	$ilya = $user->get_user(7999);
    $latest_post = $post->get_news_post(1);
    $some_server = $server->get_server(81);

	echo '<br> User: '.$ilya['login'];
	echo '<br> News Post: '.$latest_post['title'];
	echo '<br> Server: '.$some_server['title'];