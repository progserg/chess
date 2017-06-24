$(function () {
    //добавление фигуры
    $('table.add-piece tbody td button').on('click', function () {
        var type = $(this).closest('tbody').find('tr td select#type').val();
        var name = $(this).closest('tbody').find('tr td input#insert-name').val();
        var posX = parseInt($(this).closest('tbody').find('tr td select#posX').val());
        var posY = parseInt($(this).closest('tbody').find('tr td select#posY').val());
        var color = $(this).closest('tbody').find('tr td select#color').val();
        var piece = {
            "name": name,
            "type": type,
            "posX": posX,
            "posY": posY,
            "color": color
        };
        $.post('/index.php', {"action": "add", "piece": JSON.stringify(piece)}, function (data) {
            if (data != '' && isNaN(data)) {
                alert(data);
            }
            location.replace('/');
        });
        return false;
    });

    //перемещение фигуры
    $('table.move-piece tbody td button').on('click', function () {
        var name = $(this).closest('tbody').find('tr td select#name').val();
        var posX = parseInt($(this).closest('tbody').find('tr td select#move-posX').val());
        var posY = parseInt($(this).closest('tbody').find('tr td select#move-posY').val());
        var piece = {
            "name": name,
            "posX": posX,
            "posY": posY
        };
        $.post('/index.php', {"action": "move", "piece": JSON.stringify(piece)}, function (data) {
            location.replace('/');
        });
        return false;
    });

    //удаление фигуры
    $('table.del-piece tbody td button').on('click', function () {
        var name = $(this).closest('tbody').find('tr td select#del-name').val();

        $.post('/index.php', {"action": "del", "name": name}, function (data) {
            //alert(data);
            location.replace('/');
        });
        return false;
    });

    //смена типа хранилища
    $('table.type-source tbody td button').on('click', function () {
        var type = $(this).closest('tbody').find('tr td select#type-source').val();
        $.post('/', {"action": "changeSource", "type": type}, function (data) {
            location.replace('/');
        });
        return false;
    });
});