<?php

class Pieces
{
    protected $source;
    protected $pieces;
    protected $data;

    public function __construct($name = '')
    {
        $this->source = new Source();
        $this->pieces = $this->getAllPieces();
    }

    public function changeSource($type)
    {
        $this->source->changeSource($type);
    }

    protected function createPiece($type, $name, $color, $posX, $posY)
    {
        if (!empty($type) && !empty($name) && !empty($color) && $posX >= 0 && $posY >= 0) {
            return $piece = new $type($name, $color, $posX, $posY);
        }
        return false;
    }

    public function addPiece($type = null, $name = null, $color = null, $posX = null, $posY = null)
    {
        if(!empty($type) && is_array($type)){
            $name = $type['name'];
            $color = $type['color'];
            $posX = $type['posX'];
            $posY = $type['posY'];
            $type = $type['type'];
        }
        if (!empty($type) && !empty($name) && !empty($color) && $posX >= 0 && $posY >= 0) {
            $piece = $this->createPiece($type, $name, $color, $posX, $posY);
            if (!empty($piece)) {
                $this->data[$name] = [
                    'type' => $type,
                    'color' => $color,
                    'posX' => $posX,
                    'posY' => $posY
                ];
                return $this->setPieces();
            }
        }
        return false;
    }

    public function delPiece($name)
    {
        if (!empty($name) && !empty($this->data[$name])) {
            unset($this->data[$name]);
            return $this->setPieces();
        }
        return false;
    }

    public function movePiece($param = [])
    {
        if(!empty($param)){

            if(is_numeric($param['posX']) && is_numeric($param['posY'])){
                if (!empty($param['name']) && !empty($this->data[$param['name']])) {
                    $this->data[$param['name']]['posX'] = $param['posX'];
                    $this->data[$param['name']]['posY'] = $param['posY'];
                    return $this->setPieces();
                }
            }
        }
        return false;
    }

    public function getPiece($name)
    {
        if (!empty($name) && !empty($this->data[$name])) {
            return $this->data[$name];
        }
        return false;
    }

    public function getAllPieces()
    {
        $this->data = $this->source->getData();
        if (!empty($this->data)) {
            foreach ($this->data as $key => $value) {
                $this->pieces[$key] = new $value['type']($key, $value['color'], $value['posX'], $value['posY']);
            }
            return $this->pieces;
        }
        return false;
    }
    public function setPieces()
    {
        return $this->source->setPieces($this->data);
    }
}

abstract class Piece
{
    public $name;
    public $color;
    public $posX;
    public $posY;

    public function __construct($name = 'pawn', $color, $posX, $posY)
    {
        $this->name = $name;
        $this->color = $color;
        $this->posX = $posX;
        $this->posY = $posY;
    }

    public function movePiece($name)
    {
        if (!empty($name)) {

        }
    }
}

class Pawn extends Piece
{

}

class Rook extends Piece
{

}

class Knight extends Piece
{

}

class Bishop extends Piece
{

}

class Queen extends Piece
{

}

class King extends Piece
{

}