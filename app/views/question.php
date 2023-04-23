<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Задать вопрос менеджеру</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
    <style>
        .popup-fade {
            display: none;
        }
        .popup-fade:before {
            content: '';
            background: #000;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            opacity: 0.7;
            z-index: 9999;
        }
        .popup {
            position: fixed;
            top: 20%;
            left: 50%;
            padding: 20px;
            width: 360px;
            margin-left: -200px;
            background: #fff;
            border: 1px solid orange;
            border-radius: 4px;
            z-index: 99999;
            opacity: 1;
        }
        .popup-close {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="stat.html">EcoCar</a>
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
        <form action="/question" method="post">
            <div class="form-header">
                <h4>Задать вопрос менеджеру</h4>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Как к Вам можно обращаться</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email для связи</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
            </div>
            <div class="mb-3">
                <label for="question" class="form-label">Вопрос</label>
                <textarea class="form-control" id="question" rows="3" name="question"></textarea>
            </div>
            <div class="form-footer">
                <div class="form-buttons">
                    <input type="submit" class="btn btn-success" id="popup-open" value="Отправить вопрос">
                </div>
            </div>
        </form>
    </div>
</div>
<div class="popup-fade">
    <div class="popup">
        <a class="popup-close" href="#">Закрыть</a>
        <h4>Спасибо за Ваше обращение!</h4>
        <p>
            Наш менеджер постарается ответить на Ваш вопрос в ближайшее время.
        </p>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    $(document).ready(function($) {
        // Клик по ссылке "Закрыть".
        $('.popup-close').click(function() {
            $(this).parents('.popup-fade').fadeOut();
            return false;
        });

        <?if($result['result']):?>
            $('.popup-fade').fadeIn();
        <?endif;?>

        // Закрытие по клавише Esc.
        $(document).keydown(function(e) {
            if (e.keyCode === 27) {
                e.stopPropagation();
                $('.popup-fade').fadeOut();
            }
        });

        // Клик по фону, но не по окну.
        $('.popup-fade').click(function(e) {
            if ($(e.target).closest('.popup').length == 0) {
                $(this).fadeOut();
            }
        });
    });
</script>
</body>
</html>