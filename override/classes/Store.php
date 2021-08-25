<?php


class Store extends StoreCore
{
    public $id_group;
    public function __construct($idStore = null, $idLang = null){
        self::$definition['fields']['id_group']   = [
            'type' => self::TYPE_INT,
            'validate' => 'isUnsignedId',
            'required' => false
        ];
        parent::__construct($idStore, $idLang);
    }
}