<?php //require_once __DIR__ . '/run.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>English - Добавление данные в БД</title>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
</head>
<body>

<div class="section polls_type1">
    <h2>Опрос ТИП 1</h2>
    <form id="polls_type1">
        <input type="text" name="quest" placeholder="Вопрос">
        <input type="text" name="correct_answer" placeholder="Правильный ответ">
        <textarea name="answers" title="Ответы" rows="3" placeholder="Неправильные ответы" style="vertical-align:middle;"></textarea>
        <input type="hidden" name="secret" value="fj3243H#F2pf2h3f8p9@F">
        <input type="submit" title="Отравить">
    </form>
</div>

<div id="test"></div>

</body>
</html>
