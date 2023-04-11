<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Регистрация в системе EcoCar</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
</head>
<body>
<div class="container-fluid d-flex h-100 justify-content-center align-items-center p-0">
	<div class="col-sm-12 col-md-8 col-md-offset-2 col-lg-6">
		<form action="/signup/" method="POST">
			<div class="form-header">
				<h4>Регистрация в системе</h4>
			</div>
			<div class="mb-3">
				<label for="email" class="form-label">Email адрес</label>
				<input type="email" class="form-control" id="email" placeholder="name@example.com" name="email" value="<?= $result['values']['email'] ?? '' ?>">
				<div class="form-check">
					<input class="form-check-input" type="checkbox" value="" id="email-check-agreement" name="mailingAgreement">
					<label class="form-check-label" for="email-check-agreement">
						Я согласен получать рекламную рассылку
					</label>
				</div>
			</div>
			<div class="mb-3">
				<label for="sensorId" class="form-label">Введите идентификатор вашего датчика</label>
				<input type="text" class="form-control" id="sensorId" placeholder="000XXX00" name="sensor" value="<?= $result['values']['sensor'] ?? '' ?>">
			</div>
			<div class="mb-3">
				<label for="password" class="form-label">Придумайте сложный пароль</label>
				<input type="password" class="form-control" id="password" name="password">
			</div>
			<div class="mb-3">
				<label for="passwordRepeat" class="form-label">Повторите пароль</label>
				<input type="password" class="form-control" id="passwordRepeat" name="repeatedPassword">
			</div>
            <h5>Данные об автомобиле</h5>
            <div class="mb-3">
                <label for="carName" class="form-label">Название автомобиля</label>
                <select class="selectpicker form-select" id="carName" data-live-search="true" name="car">
                    <optgroup label="Отечественные">
                        <!--<option>ВАЗ 2114</option>
                        <option>ВАЗ 2115</option>-->
                        <option value="1" selected>УАЗ Patriot 3163 I</option>
                    </optgroup>
                    <optgroup label="Иномарки">
                        <option value="2" selected>Toyota Land Cruiser 200</option>
                        <!--<option>Nissan x-trail t31</option>
                        <option>Mitsubishi pajero 2</option>-->
                    </optgroup>
                </select>
            </div>
            <div class="mb-3">
                <label for="datepicker" class="form-label">Год выпуска</label>
                <input type="text" class="form-control" name="year" id="datepicker" value="<?= $result['values']['year'] ?? '' ?>"/>
            </div>
            <div class="mb-3">
                <label for="engineType" class="form-label">Тип двигателя</label>
                <select class="selectpicker form-select" id="engineType" data-live-search="true" name="engineType">
                    <option value="1" selected>Бензиновый</option>
                    <option value="2">Дизельный</option>
                </select>
            </div>
			<div class="form-footer">
                <?if(isset($result['errors'])):?>
                    <?foreach ($result['errors'] as $error):?>
                        <div class="alert alert-danger" role="alert">
                            <?=$error?>
                        </div>
                    <?endforeach;?>
                <?endif;?>
				<p>Уже зарегистрированы? <a href="/">Авторизоваться.</a> </p>
				<div class="form-buttons">
					<input type="submit" class="btn btn-success" value="Зарегистрироваться">
					<button type="button" class="btn btn-danger">Очистить форму</button>
				</div>
			</div>
		</form>
	</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<script>
    $("#datepicker").datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
        autocomplete: true
    });
</script></body>
</html>