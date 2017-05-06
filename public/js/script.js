$(document).ready(function () {
    $("#polls_type1").find("input[type='submit']").on("click", function (e) {
        var quest = $("#polls_type1").find("input[name='quest']").val();
        var correct_answer = $("#polls_type1").find("input[name='correct_answer']").val();
        var answers = $("#polls_type1").find("textarea[name='answers']").val().split("\n");
        var secret = $("#polls_type1").find("input[name='secret']").val();

        $.ajax({
            url: "controllers/polls_type1.php",
            type: "GET",
            data: {
                'quest': quest,
                'correct_answer': correct_answer,
                'answers': answers,
                'secret': secret
            },
            success: function (res) {
                console.log(res);
            }
        });

        e.preventDefault();
    })
});
