<?php require_once __DIR__ . '/run.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>English - Добавление данных в БД</title>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
</head>
<body>

<div class="section polls_type1">
    <h2>Poll Type 1</h2>
    <form id="poll_type1">
        <input type="text" name="quest" placeholder="Quest" onblur="help();">
        <input type="text" name="correct_answer" placeholder="Correct_answer">
        <textarea name="answers" title="Ответы" rows="3" placeholder="Answers" style="vertical-align:middle;"></textarea>
        <input type="hidden" name="secret" value="<?= \gvk\Config::setRandomSecretKey(); ?>">
        <input type="submit" title="Отравить">
        <div id="success"></div>
    </form>
</div>

</body>
</html>
