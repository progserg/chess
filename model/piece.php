<?php

//класс Фигура и её методы
class Piece
{

    public $color;
    public $posX;
    public $posY;
    protected $allowed_types;
    public $name;
    public $type;
    protected $source;
    protected $pieces;

    public function __construct($source)
    {
        //получили экземпляр объекта source
        $this->source = (object)$source;
        //получили фигуры
        $this->pieces = $this->source->getPieces();
    }

    //добавление фигуры
    public function add($piece)
    {
        //если фигуры есть
        if (count($this->pieces) > 0) {
            //проверяем, есть ли уже такая фигура
            if ($this->exists((array)$piece, $this->pieces)) {
                //если есть, то ничего не добавляем
                return false;
            }
        }
        //добавляем фигуру в массив
        $this->pieces[] = (object)$piece;

        //сохраняем данные о фигурах
        if ($this->source->setPieces($this->pieces)) {
            if ($piece->type == 'pawn') {
                return 'Пешка добавлена';
            }
            return true;
        }
        return false;
    }

    //удаление фигуры
    public function del($piece)
    {
        $piece = (object)$piece;
        //перебираем все фигуры
        foreach ($this->pieces as $key => $item) {
            $item = (object)$item;
            if ($item->name == $piece->name) { //если есть фигура с похожим именем
                unset($this->pieces[$key]);     //удаляем ее из массива
                break;
            }
        }
        //пишем в систему хранения
        return $this->source->setPieces($this->pieces);
    }

    //перемещение фигуры
    public function move($piece)
    {
        $piece = (object)$piece;
        foreach ($this->pieces as $key => $item) {
            $item = (object)$item;
            if ($item->name == $piece->name) {      //если есть фигура с таким именем, обновляем ей данные
                $this->pieces[$key]['name'] = 'piece_' . ($piece->posX / 50) . ($piece->posY / 50);
                $this->pieces[$key]['posX'] = $piece->posX;
                $this->pieces[$key]['posY'] = $piece->posY;
                //пишем в систему хранения
                return $this->source->setPieces($this->pieces);
            }
        }
    }

    //проверка наличия фигуры
    public function exists($piece)
    {
        //проверяется соответствие объекта полностью
        if (in_array($piece, $this->pieces)) {
            return true;
        }
        return false;
    }
}