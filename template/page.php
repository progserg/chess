<!--шаблон-->
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=1024 initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chess</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="clearfix">
    <div class="table">
        <table>{$board}</table>
    </div>
    <div class="controls">
        <table class="add-piece">
            <thead>
                <tr>
                    <th>Тип фигуры</th>
                    <th>Название</th>
                    <th>Позиция по X</th>
                    <th>Позиция по Y</th>
                    <th>Цвет</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="type" id="type">
                            <option value="Pawn">pawn</option>
                            <option value="Rook">rook</option>
                            <option value="Knight">knight</option>
                            <option value="Bishop">bishop</option>
                            <option value="Queen">queen</option>
                            <option value="King">king</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" placeholder="Пешка" id="insert-name">
                    </td>
                    <td>
                        <select name="posX" id="posX">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                        </select>
                    </td>
                    <td>
                        <select name="posY" id="posY">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                        </select>
                    </td>
                    <td>
                        <select name="color" id="color">
                            <option value="white">white</option>
                            <option value="black">black</option>
                        </select>
                    </td>
                    <td>
                        <button>Добавить фигуру</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="move-piece">
            <thead>
            <tr>
                <th>Имя фигуры</th>
                <th>Переместить по X</th>
                <th>Переместить по Y</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <select name="name" id="name">
                        {$pieceNames}
                    </select>
                </td>
                <td>
                    <select name="posX" id="move-posX">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                    </select>
                </td>
                <td>
                    <select name="posY" id="move-posY">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                    </select>
                </td>
                <td>
                    <button>Переместить фигуру</button>
                </td>
            </tr>
            </tbody>
        </table>
        <table class="del-piece">
            <thead>
            <tr>
                <th>Имя фигуры</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <select name="name" id="del-name">
                        {$pieceNames}
                    </select>
                </td>
                <td>
                    <button>Удалить фигуру</button>
                </td>
            </tr>
            </tbody>
        </table>
        <table class="type-source">
            <thead>
            <tr>
                <th>Тип хранилища</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <select name="type-source" id="type-source">
                        <option value="file">File</option>
                        <option value="redis">Redis</option>
                    </select>
                </td>
                <td>
                    <button>Сменить систему хранения</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="about">
        <h1>Шахматное поле</h1>
        <p>
            Вы можете добавить фигуры, выбрав тип фигуры, ее положение на доске и цвет из списка.
        </p>
        <p>
            Созданные фигуры можно перемещать по полю, путем выбора имени фигуры и координат для перемещения.
        </p>
        <p>
            Удалить фигуру можно выбрав ее имя.
        </p>
        <p>
            Также есть возможность изменить тип хранилища данных о фигурах. При смене типа хранилища, данные копируются из старого в новое хранилище.
        </p>
        <p>
            Данные о размере доски и доступных типах хранилищ хранятся в файле system.json и изменяются только при смене типа хранилища.
        </p>
        <p>
            Данные о фигурах хранятся в файле data.json - данное хранилище является резервным, и в случае недоступности redis используется оно.
        </p>
    </div>
</div>
<script type="text/javascript" src="../assets/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="../assets/js/script.js"></script>
</body>
</html>