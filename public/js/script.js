$(document).ready(function () {
    $("#poll_type1").find("input[type='submit']").on("click", function (e) {
        var id = $("#poll_type1");

        var quest = id.find("input[name='quest']");
        var correct_answer = id.find("input[name='correct_answer']");
        var answers = id.find("textarea[name='answers']");
        var secret = id.find("input[name='secret']").val();

        var text = quest.val() + "\n" + correct_answer.val() + "\n" + answers.val();

        $.ajax({
            url: "controllers/control.php",
            type: "GET",
            data: {
                'action': 'poll_type1',
                'text':   text,
                'secret': secret
            },
            success: function (res) {
                quest.focus();
                id.find("#success").empty();

                if (res) {
                    quest.empty();
                    correct_answer.empty();
                    answers.empty();

                    id.find("#success").append("Новый опрос добавлен");
                    return;
                }

                id.find("#success").append("Ошибка");
            }
        });

        e.preventDefault();
    })
});

function help() {
    var id = $("#poll_type1");

    $.ajax({
        url: "controllers/help.php",
        type: "GET",
        data: {
            'action': 'poll_type1',
            'quest':  id.find("input[name='quest']").val(),
            'secret': id.find("input[name='secret']").val()
        },
        success: function (res) {
            if (res)
                id.css('background', '#333');
            else
                id.css('background', '#fff');
        }
    });
}
