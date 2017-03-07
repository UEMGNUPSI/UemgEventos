<?php 


session_start();

$erro = isset($_GET['erro']) ? $_GET['erro'] : 0;
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
<div class="container">
<div class="col-md-12">
	<h2>Por favor, realize o login para continuar!</h2>
</div>
<div class="col-md-3">

<form method="post" action="validar_acesso.php" id="formLogin">

	<div class="form-group">
		<input type="text" class="form-control" id="campo_usuario" name="usuario" placeholder="Usuário" />
	</div>

	<div class="form-group">
		<input type="password" class="form-control red" id="campo_senha" name="senha" placeholder="Senha" maxlength="20"/>
	</div>

	
	<button type="buttom" class="btn btn-primary" id="btn_login">Entrar</button>

	<br /><br />
	<?php 
		if($erro == 2){
			echo '<font color=#FF0000>Usuario ou senha inválidos</font>';
		}
	 ?>
</form>
</div>
</div>
</body>
</html>