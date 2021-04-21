<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <title>Сайт на реконструкции</title>
</head>
<body class="d-flex">
  <div class="container d-flex justify-content-center align-items-center">
    <div class="row">
      <div class="col-12 text-center">
        <h1 class="w-100 text-center">Сайт на реконструкции</h1>
        <p>Мы приносим свои изменения</p>
        <small>С уважением Wallride Store</small>
        <h3 id="timer"></h3>
      </div>
    </div>
  </div>

  <script>
    // Берём элемент для вывода таймера
    let timer_show = document.getElementById("timer");

    // Функция для вычисления разности времени
    function diffSubtract(date1, date2) {
      return date2 - date1;
    }

    // Массив данных о времени
    let end_date = {
      "full_year": "2021", // Год
      "month": "04", // Номер месяца
      "day": "21", // День
      "hours": "20", // Час
      "minutes": "00", // Минуты
      "seconds": "00" // Секунды
    }

    // Строка для вывода времени
    let end_date_str = `${end_date.full_year}-${end_date.month}-${end_date.day}T${end_date.hours}:${end_date.minutes}:${end_date.seconds}`;

    // Запуск интервала таймера
    timer = setInterval(function () {
      // Получение времени сейчас
      let now = new Date();
      // Получение заданного времени
      let date = new Date(end_date_str);
      // Вычисление разницы времени
      let ms_left = diffSubtract(now, date);
      // Если разница времени меньше или равна нулю
      if (ms_left <= 0) { // То
        // Выключаем интервал
        clearInterval(timer);
        // Выводим сообщение об окончание
        alert("Время закончилось");
      } else { // Иначе
        // Получаем время зависимую от разницы
        let res = new Date(ms_left);
        // Делаем строку для вывода
        // Выводим время
        timer_show.innerHTML = `${res.getUTCDate() - 1} Дней  ${res.getUTCHours()}:${res.getUTCMinutes()}:${res.getUTCSeconds()}`;
      }
    }, 1000)
  </script>
</body>
</html>
