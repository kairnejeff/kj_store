<?php


class kj_store_object extends ObjectModel
{
    public $name;
    public static $definition = array(
        'table' => 'group_store',
        'primary' => 'id_group_store',
        'fields' => array(
            'name' =>			array('type' => self::TYPE_STRING,'size' => 255),
        )
    );

    public	function __construct($id_group_store = null)
    {
        parent::__construct($id_group_store);
    }

    public static function getAllGroups(){
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
                 Select * from `'._DB_PREFIX_.'group_store`
        ');
    }

}