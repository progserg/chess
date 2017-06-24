<?php

class Board
{
    public $size;
    public $type;
    protected $source;

    public function __construct()
    {
        $this->source = new Source();
        $this->size = $this->source->getSystemData()->board;
        $this->type = $this->source->getSystemData()->dataSource;
    }
}