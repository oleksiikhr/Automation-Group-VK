<?php require_once __DIR__ . '/run.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>English - Добавление данных в БД</title>

    <link href="css/style.css" rel="stylesheet">

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/axios.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
</head>
<body>

<div class="section poll_type1">
    <span>Вопрос 1</span>

    <form id="poll_type1">
        <input type="text" name="quest" placeholder="Вопрос" onblur="findPoll('poll_type1');" required>
        <input type="text" name="correct_answer" placeholder="Правильный ответ" required>
        <textarea name="answers" title="Ответы" rows="4" placeholder="Ответы" required></textarea>
        <input type="hidden" name="secret" value="<?= \gvk\Config::setRandomSecretKey(); ?>">
        <input type="hidden" name="action" value="add">
        <input type="submit" value="Добавить" onclick="sendPoll('poll_type1'); return false;">
    </form>
</div>

<div class="section poll_type2">
    <span>Вопрос 2</span>

    <form id="poll_type2">
        <input type="text" name="quest" placeholder="Вопрос" onblur="findPoll('poll_type2');" required>
        <input type="text" name="correct_answer" placeholder="Правильный ответ" required>
        <textarea name="answers" title="Ответы" rows="4" placeholder="Ответы" required></textarea>
        <input type="hidden" name="secret" value="<?= \gvk\Config::setRandomSecretKey(); ?>">
        <input type="hidden" name="action" value="add">
        <input type="submit" value="Добавить" onclick="sendPoll('poll_type2'); return false;">
    </form>
</div>

<div class="section poll_type3">
    <span>Вопрос 3</span>

    <form id="poll_type3">
        <input type="text" name="correct_answer" placeholder="Правильный ответ" onblur="findPoll('poll_type3');" required>
        <textarea name="answers" title="Ответы" rows="4" placeholder="Ответы" required></textarea>
        <input type="hidden" name="secret" value="<?= \gvk\Config::setRandomSecretKey(); ?>">
        <input type="hidden" name="action" value="add">
        <input type="submit" value="Добавить" onclick="sendPoll('poll_type3'); return false;">
    </form>
</div>

<div class="section youtube">
    <span>Youtube</span>

    <form id="youtube">
        <input type="text" name="title" placeholder="Название" required>
        <input type="text" name="playlist" placeholder="Плейлист" required>
        <input type="hidden" name="secret" value="<?= \gvk\Config::setRandomSecretKey(); ?>">
        <input type="submit" value="Добавить" onclick="sendYoutube(); return false;">
    </form>

</body>
</html>