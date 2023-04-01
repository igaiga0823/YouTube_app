<?php
session_start();
require('../../dbconnect.php');

if (isset($_GET['action']) && $_GET['action'] === 'rewrite' && isset($_SESSION['form'])) {
	$form = $_SESSION['form'];
} else {
	$form = [
		'name' => '',
		'API' => '',
		'password' => '',
	];
}
$error = [];

/* フォームの内容をチェック */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$form['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
	if ($form['name'] === '') {
		$error['name'] = 'blank';
	}

	$form['API'] = filter_input(INPUT_POST, 'API', FILTER_SANITIZE_API);
	if ($form['API'] === '') {
		$error['API'] = 'blank';
	} else {
		$db = dbconnect();
		$stmt = $db->prepare('select count(*) from users where API=?');
		if (!$stmt) {
			die($db->error);
		}
		$stmt->bind_param('s', $form['API']);
		$success = $stmt->execute();
		if (!$success) {
			die($db->error);
		}
		$stmt->bind_result($cnt);
		$stmt->fetchtmlspecialchars();

		if ($cnt > 0) {
			$error['API'] = 'duplicate';
		}
	}

	$form['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
	if ($form['password'] === '') {
		$error['password'] = 'blank';
	} else if (strlen($form['password']) < 4) {
		$error['password'] = 'length';
	}
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>会員登録</title>

	<link rel="stylesheet" href="../style.css" />
</head>

<body>
	<div id="wrap">
		<div id="head">
			<h1>会員登録</h1>
		</div>

		<div id="content">
			<p>次のフォームに必要事項をご記入ください。</p>
			<form action="" method="post" enctype="multipart/form-data">
				<dl>
					<dt>ニックネーム<span class="required">必須</span></dt>
					<dd>
						<input type="text" name="name" size="35" maxlength="255" value="<?php echo htmlspecialchars($form['name']); ?>" />
						<?php if (isset($error['name']) && $error['name'] === 'blank') : ?>
							<p class="error">* ニックネームを入力してください</p>
						<?php endif; ?>
					</dd>
					<dt>API<span class="required">必須</span></dt>
					<dd>
						<input type="text" name="API" size="35" maxlength="255" value="<?php echo htmlspecialchars($form['API']); ?>" />
						<?php if (isset($error['API']) && $error['API'] === 'blank') : ?>
							<p class="error">* APIを入力してください</p>
						<?php endif; ?>
						<?php if (isset($error['API']) && $error['API'] === 'duplicate') : ?>
							<p class="error">* 指定されたAPIはすでに登録されています</p>
						<?php endif; ?>
					<dt>パスワード<span class="required">必須</span></dt>
					<dd>
						<input type="password" name="password" size="10" maxlength="20" value="<?php echo htmlspecialchars($form['password']); ?>" />
						<?php if (isset($error['password']) && $error['password'] === 'blank') : ?>
							<p class="error">* パスワードを入力してください</p>
						<?php endif; ?>
						<?php if (isset($error['password']) && $error['password'] === 'length') : ?>
							<p class="error">* パスワードは4文字以上で入力してください</p>
						<?php endif; ?>
					</dd>
				</dl>
				<div><button type="submit" value="入力内容を確認する">かくにん</button></div>
			</form>
		</div>
</body>

</html>