<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="<?php CSS_PATH."style.css" ?>">
</head>
<body>
	<form action="<?php FRONT_ROOT."User/SignUp"?>"class="login-form bg-dark-alpha p-5 text-white">
		<div><input class="form-control form-control-lg" type="text" name="userName" placeholder="userName"></div>
		<div><input class="form-control form-control-lg"type="password" name="password1" placeholder="enter new password"></div>
		<div><input class="form-control form-control-lg" type="password" name="password2" placeholder="confirm your password"></div>
		<div><input class="form-control form-control-lg" type="text" name="" placeholder="E-mail"></div>
		<div><input class="form-control form-control-lg" type="text" name="" placeholder="First Name"></div>
		<div><input class="form-control form-control-lg" type="text" name="" placeholder="Last Name"></div>

		<div><input class="form-control form-control-lg" type="text" name="" placeholder="DNI"></div>
	
		<div><input class="btn btn-dark btn-block btn-lg" type="submit" name="sign" value="send"></div>
	</form>
	
</body>
</html>
