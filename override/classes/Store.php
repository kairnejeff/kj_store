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

    public static function getStores($idLang)
    {
        $stores = Db::getInstance()->executeS(
            '
            SELECT s.id_store AS `id`, s.*, sl.*,gs.*
            FROM ' . _DB_PREFIX_ . 'store s
            ' . Shop::addSqlAssociation('store', 's') . '
            LEFT JOIN ' . _DB_PREFIX_ . 'store_lang sl ON (
            sl.id_store = s.id_store
            AND sl.id_lang = ' . (int) $idLang . '
            )
            LEFT JOIN ' . _DB_PREFIX_ . 'group_store gs ON 
            (gs.`id_group_store` = s.`id_group`) 
            WHERE s.active = 1'
        );

        return $stores;
    }
}