$(document).ready(function () {
    $("#polls_type1").find("input[type='submit']").on("click", function (e) {
        var id = $("#polls_type1");

        var quest = id.find("input[name='quest']").val();
        var correct_answer = id.find("input[name='correct_answer']").val();
        var answers = id.find("textarea[name='answers']").val();
        var secret = id.find("input[name='secret']").val();

        var text = quest + "\n" + correct_answer + "\n" + answers;

        console.log(text);

        $.ajax({
            url: "controllers/polls_type1.php",
            type: "GET",
            data: {
                'text': text,
                'secret': secret
            },
            success: function (res) {
                if (res === "good") {
                    id.find("#error").append(res);
                }
                console.log(res);
            }
        });

        e.preventDefault();
    })
});
