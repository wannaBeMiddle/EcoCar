<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Авторизация в системе EcoCar</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
</head>
<body>
<div class="container-fluid d-flex h-100 justify-content-center align-items-center p-0">
	<div class="col-sm-12 col-md-8 col-md-offset-2 col-lg-6">
		<form action="/" method="POST">
			<div class="form-header">
				<h4>Авторизация в системе</h4>
			</div>
			<div class="mb-3">
				<label for="email" class="form-label">Email адрес</label>
				<input type="email" class="form-control" id="email" placeholder="name@example.com" name="email" value="<?= $result['email'] ?? '' ?>">
			</div>
			<div class="mb-3">
				<label for="password" class="form-label">Пароль</label>
				<input type="password" class="form-control" id="password" name="password">
			</div>
			<div class="form-footer">
				<?if(isset($result['errors'])):?>
					<?foreach ($result['errors'] as $error):?>
                        <div class="alert alert-danger" role="alert">
							<?=$error?>
                        </div>
					<?endforeach;?>
				<?endif;?>
				<p>Еще не зарегистрированы? <a href="/signup/">Зарегистрироваться.</a> </p>
				<div class="form-buttons">
                    <input type="submit" class="btn btn-success" value="Войти">
				</div>
			</div>
		</form>
	</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
</body>
</html>