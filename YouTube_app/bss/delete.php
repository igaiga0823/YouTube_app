<?php
session_start();
require('library.php');

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
	$id = $_SESSION['id'];
	$name = $_SESSION['name'];
} else {
	header('Location: login.php');
	exit();
}

$post_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$post_id) {
    header('Location: index.php');
    exit();
}

$db = dbconnect();
$stmt = $db->prepare('delete from posts where id=? and member_id=? limit 1');
if (!$stmt) {
    die($db->error);
}
$stmt->bind_param('ii', $post_id, $id);
$success = $stmt->execute();
if (!$success) {
    die($db->error);
}

header('Location: index.php'); exit();
?>
