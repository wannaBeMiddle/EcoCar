<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>#TITLE#</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>

</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/stat/">EcoCar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/stat/">Моё авто</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/profile/">Личный кабинет</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/question/">Задать вопрос</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/edit/">Ввести показания</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link-danger" href="/logout/">Выйти</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid d-flex h-100 justify-content-center align-items-center p-0">
    <div class="col-sm-12 col-md-8 col-md-offset-2 col-lg-6">
<?$this->setTitle("Личный кабинет");?>
<form action="/profile/" method="post">
    <div class="form-header">
        <h4>Личный кабинет</h4>
        <p>
            Тут вы можете сменить некоторые данные
        </p>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email адрес</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="<?=$result['user']['email']??''?>">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Новый пароль</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <div class="mb-3">
        <label for="passwordRepeat" class="form-label">Повторите пароль</label>
        <input type="password" class="form-control" id="repeated_password" name="repeated_password">
    </div>
    <div class="mb-3">
        <label for="sensorId" class="form-label">Идентификатор датчика</label>
        <input type="text" class="form-control" id="sensorId" placeholder="000XXX00" name="sensor" value="<?=$result['user']['code']??''?>" readonly>
    </div>
    <h5>Данные об автомобиле</h5>
    <div class="mb-3">
        <label for="carName" class="form-label">Название автомобиля</label>
        <select class="selectpicker form-select" id="carName" data-live-search="true" name="car">
            <?foreach ($result['cars'] as $countries => $models):?>
            <optgroup label="<?=$countries?>">
                <?foreach ($models as $model):?>
                    <option value="<?=$model['id']?>" <?=$model['id']==$result['user']['model']?'selected':''?>><?=$model['name']?></option>
                <?endforeach;?>
            <?endforeach;?>
        </select>
    </div>
    <div class="mb-3">
        <label for="datepicker" class="form-label">Год выпуска</label>
        <input type="text" class="form-control" name="datepicker" id="datepicker" value="<?=$result['user']['manufacturedYear']??''?>"/>
    </div>
    <div class="form-footer">
        <?if(isset($result['errors'])):?>
            <?foreach ($result['errors'] as $errors):?>
                <div class="alert alert-danger" role="alert">
                    <?foreach ($errors as $error):?>
                    <?=$error?>
                    <?endforeach;?>
                </div>
            <?endforeach;?>
        <?endif;?>
        <div class="form-buttons">
            <input type="submit" class="btn btn-success" value="Сохранить данные">
        </div>
    </div>
</form>
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