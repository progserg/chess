<?php
require __DIR__ . '/model/piece.php';
require __DIR__ . '/model/source.php';

$source = new Source();
$pieceObj = new Piece($source);
//получаем данные о системе: размер доски, тип хранения системы
$systemData = $source->getSystemData();
//получаем фигуры
$pieces = $source->getPieces();

//флаг указывающий заполнять доску фигурами или нет. true - не заполнять, false - заполнять
$empty = empty($pieces)?true:false;

//обработка POST запросов
if(!empty($_POST['action'])){
    if($_POST['action'] == 'add'){
        //echo $_POST['piece'];
        echo $pieceObj->add(json_decode($_POST['piece'], true));
    }
    if($_POST['action'] == 'move'){
        echo $pieceObj->move(json_decode($_POST['piece'], true));
    }
    if($_POST['action'] == 'del'){
        echo $pieceObj->del(json_decode($_POST['piece'], true));
    }
    if($_POST['action'] == 'changeSource'){
        echo $source->changeSource($_POST['type']);
    }
    exit;
}
//формируем страницу
$board = createBoard($systemData->board, $empty, $source->getTypeSource());
//и сразу ее возвращаем, если фигур нет
if($empty){
    echo $board;
    exit;
}
//заполняем фигурами
echo fillBoard($pieces, $systemData->board, $board);

////////////////////////////////////////////////////////////////\
//заполняем поле фигурами
function fillBoard($pieces, $size, $board)
{
    //перебираем всю доску ..
    for($i = 0; $i < $size; $i++){
        for($j = 0; $j < $size; $j++){
            $pattern = '{piece_' . $i . $j . '}';
            $replacement = '';
            foreach ($pieces as $item){
                $item = (object)$item;
                if(('{' . $item->name . '}') == $pattern){
                    $replacement = '<div class="piece '. $item->color .'">'. substr($item->type,0,1) .'</div>';
                }
            }
            //..и заменяем все совпавшие имена данными об объекте. не совпавшие заменяем пустими значениями
            $board = str_replace($pattern, $replacement, $board);
        }
    }
    //заполняем выпадающий список именами фигур
    $names = '';
    foreach ($pieces as $item){
        $item = (object)$item;
        $names .= '<option value="'. $item->name .'">' . $item->name . '</option>';
    }
    $board = str_replace('{$pieceNames}', $names, $board);

    return $board;
}

//формирование базовой страницы
function createBoard($size, $empty, $typeSource)
{
    //подгружаем шаблон
    $template = file_get_contents(__DIR__ . '/template/page.php');

    //создаем шахматное поле
    $page = '';
    for($i = 0; $i < ($size); $i++){
        $page.= '<tr>';
        for ($j = 0; $j < ($size); $j++){
            $page .= '<td><div class="field">';
            if(!$empty){
                $page .= '{piece_'. $j . $i . '}';
            }
            $page .= '</div></td>';
        }
        $page .= '</tr>';
    }
    //вставляем поле в шаблон
    $page = str_replace('{$board}', $page, $template);
    //устанавливаем текущий тип системы хранения
    $page = str_replace('"' . $typeSource . '"', '"'. $typeSource .'" selected="selected"', $page);
    return $page;
}