<?php
//подключение модуля для работы с Redis
require __DIR__ . '/model/predis/autoload.php';
include __DIR__ . '/model/source.php';
include __DIR__ . '/model/piece.php';
include __DIR__ . '/model/board.php';

$objPieces = new Pieces();
$systemData = new Board();
$size = $systemData->size;
$type = $systemData->type;

//обработка POST запросов
if(!empty($_POST['action'])){
    if($_POST['action'] == 'add'){
        //echo $_POST['piece'];
        //echo var_dump(json_decode($_POST['piece'], true));
        $objPieces->addPiece(json_decode($_POST['piece'], true));
    }
    if($_POST['action'] == 'move'){
        echo $objPieces->movePiece(json_decode($_POST['piece'], true));
    }
    if($_POST['action'] == 'del'){
        echo $objPieces->delPiece($_POST['name']);
    }
    if($_POST['action'] == 'changeSource'){
        echo $objPieces->changeSource($_POST['type']);
    }
    exit;
}
$pieces = $objPieces->getAllPieces();
//флаг указывающий заполнять доску фигурами или нет. true - не заполнять, false - заполнять
$empty = empty($pieces)?true:false;

//формируем страницу
$page = createBoard($size, $empty, $type);
//и сразу ее возвращаем, если фигур нет
if($empty){
    echo $page;
    exit;
}
//заполняем фигурами
echo fillBoard($pieces, $size, $page);

////////////////////////////////////////////////////////////////\
//заполняем поле фигурами
function fillBoard($pieces, $size, $page)
{
    //перебираем всю доску ..
    for($i = 0; $i < $size; $i++){
        for($j = 0; $j < $size; $j++){
            $pattern = '{piece_' . $i . $j . '}';
            $replacement = '';
            foreach ($pieces as $key => $item){
                if(('{piece_' . $item->posX . $item->posY . '}') == $pattern){
                    $replacement = '<div class="piece '. $item->color .'">'. substr($key,0,1) .'</div>';
                }
            }
            //..и заменяем все совпавшие имена данными об объекте. не совпавшие заменяем пустими значениями
            $page = str_replace($pattern, $replacement, $page);
        }
    }
    //заполняем выпадающий список именами фигур
    $names = '';
    foreach ($pieces as $key => $item){
        $names .= '<option value="'. $key .'">' . $key . '</option>';
    }
    $page = str_replace('{$pieceNames}', $names, $page);

    return $page;
}

//формирование базовой страницы
function createBoard($size, $empty, $type)
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
    $page = str_replace('"' . $type . '"', '"'. $type .'" selected="selected"', $page);
    return $page;
}