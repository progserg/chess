<?php
//информация о системе - информация о размере доски и о типе системы хранения

//класс для работы с хранилищами данных
class Source{
    protected $systemFile;
    protected $systemPath;
    protected $dataSourcePath;
    protected $redis;
    protected $redisKey;
    protected $typeSource;

    /*================*/
    protected $data;
    /*================*/

    public function __construct()
    {
        //системные пути
        $this->systemPath = __DIR__ . '/../config/system.json';
        $this->dataSourcePath = __DIR__ . '/../config/data.json';
        $this->initial();
    }

    //инициализация всех переменных класса
    public function initial()
    {
        //загрузка данных о системе
        $this->systemFile = (object)json_decode(file_get_contents($this->systemPath), true);
        //тип системы хранения
        $this->typeSource = $this->systemFile->dataSource;
    }

    //загрузка данных о фигурах из файла
    public function getFromFile()
    {
        $data = $this->data = json_decode(file_get_contents($this->dataSourcePath), true);
        if(!empty($data)){
            return $data;
        }
        return false;
    }

    //создание объекта Redis и загрузка данных из хранилища redis
    public function getFromRedis()
    {
        try{
            $this->redis = new Predis\Client();
            $this->redisKey = 'key';
            return json_decode($this->redis->get($this->redisKey),true);
        }catch (Exception $e){
            //в случае ошибки грузим фигуры из файла
            $this->setSystemData(null, 'file');
            $this->getFromFile();
        }
    }

    //загрузка данных о фигурах из файла
    public function getData()
    {
        if($this->typeSource == 'redis') {
            return $this->getFromRedis();
        }else{
            return $this->getFromFile();
        }
    }

    public function getTypeSource()
    {
        return $this->typeSource;
    }

    //переключение системы хранения с переносом данных в выбранную систему
    public function changeSource($type)
    {
        $types = ['file', 'redis'];
        if(!empty($type)){
            if($type != $this->typeSource && in_array($type, $types)){
                return $this->setSystemData(null, $type);
            }
        }
        return false;
    }

    //запись данных в файл с информацией о системе
    public function setSystemData($size, $typeSource)
    {
        if(!empty($size)){
            $this->systemFile->board = $size;
        }
        if(!empty($typeSource)){
            $this->systemFile->dataSource = $typeSource;
        }
        file_put_contents($this->systemPath, json_encode($this->systemFile, true));
    }

    public function getSystemData()
    {
        return $this->systemFile;
    }

    public function getPieces()
    {
        return $this->pieces;
    }

    //запись данных о фигурах
    public function setPieces($pieces)
    {
        //в redis
        if($this->typeSource == 'redis'){
            if($this->redis->set($this->redisKey, json_encode($pieces, true))){
                return true;
            }
        }else{      //в файл
            if(file_put_contents($this->dataSourcePath, json_encode($pieces, true))){
                return true;
            }
        }
        return false;
    }
}