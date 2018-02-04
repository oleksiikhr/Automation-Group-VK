function sendPoll(name) {
    var form = $("#"+name);
    var file = form.find('input[name="action"]').val() == 'add' ? 'add.php' : 'update.php';
    var inputs = form.find(':input');
    var attr = '?method='+name+'&secret='+form.find('input[name="secret"]').val();

    for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].type == 'textarea')
            attr += "&" + inputs[i].name + "=" + inputs[i].value.replace(/\n/g, '\\n');

        else if (inputs[i].type != 'hidden' && inputs[i].type != 'submit')
            attr += "&" + inputs[i].name + "=" + inputs[i].value;
    }

    axios.get('controllers/'+file+attr)
        .then(function (res) {
            if (res.data) {
                for (var i = 0; i < inputs.length; i++) {
                    if (inputs[i].type != 'hidden' && inputs[i].type != 'submit')
                        inputs[i].value = '';
                }
            }
            console.log("Response: " + res.data);
        })
        .catch(function (res) {
            console.log('Error: ' + res);
        });
}

function findPoll(name) {
    var form = $("#"+name);
    var inputs = form.find(':input');
    var attr = '?method=' + name
        + '&key=' + inputs[0].name
        + '&val=' + inputs[0].value
        + '&secret=' + form.find('input[name="secret"]').val();

    axios.get('controllers/find.php'+attr)
        .then(function (res) {
            if (res.data) {
                form.find('input[type="submit"]').attr('value', 'Обновить');
                form.find('input[type="submit"]').addClass('update');
                form.find('input[name="action"]').attr('value', 'update');
            } else {
                form.find('input[type="submit"]').attr('value', 'Добавить');
                form.find('input[type="submit"]').removeClass('update');
                form.find('input[name="action"]').attr('value', 'add');
            }
            console.log("Response: " + res.data);
        })
        .catch(function (res) {
            console.log("Error: " + res);
        });
}

function sendYoutube() {
    var title = $("#youtube").find('input[name="title"]');
    var playlist = $("#youtube").find('input[name="playlist"]');
    var secret = $("#youtube").find('input[name="secret"]');

    axios.get('controllers/add.php', {
        params: {
            method: 'youtube',
            title: title.val(),
            playlist: playlist.val(),
            secret: secret.val()
        }
    })
        .then(function (res) {
            if (res.data) {
                title.val("");
                playlist.val("");
            }
            console.log("Response: " + res.data);
        })
        .catch(function (res) {
            console.log("Error: " + res);
        });
}
