<?php
include_once(_PS_MODULE_DIR_.'kj_store/kj_store_object.php');
class kj_store extends Module
{
    protected $_html = '';
    public function __construct() {
        $this->name = 'kj_store';
        $this->author = 'Jing';
        $this->version = '1.0.0';
        $this->need_instance= 0;
        $this->bootstrap = true;
        $this->tab = 'others';
        parent::__construct();
        $this->ps_versions_compliancy = array(
            'min' => '1.7',
            'max' => _PS_VERSION_
        );
        $this->displayName = $this->l('kj_store');
        $this->description = $this->l('afficher des magasins autour de client');
    }

    public function install(){
        if (parent::install()&&$this->installSql()) {
            return true;
        }
        return false;
    }

    public function uninstall()
    {
        if (parent::uninstall()&&$this->uninstallSql()) {
            return true;
        }
        return false;
    }

    public function installSql(){
        $sqlAddColume= ' ALTER TABLE `'._DB_PREFIX_.'group_store` ADD id_group int(11) NULL';
        $sqlAddtable='
            CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'group_store` (
                `id_group_store` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `name`  VARCHAR(255)  NOT NULL,
                PRIMARY KEY (`id_group_store`)
            ) 
        ';
        return Db::getInstance()->execute($sqlAddtable)&&Db::getInstance()->execute($sqlAddColume);
    }

    protected function uninstallSql()
    {
        $sqlDropColumn='ALTER TABLE `'._DB_PREFIX_.'group_store` DROP id_group';
        $sqlDropTable='DROP TABLE IF EXISTS `'._DB_PREFIX_.'group_store`';
        return Db::getInstance()->execute($sqlDropColumn)&& Db::getInstance()->execute($sqlDropTable);
    }

    public function getContent(){
        if (Tools::isSubmit('submitGroup') || Tools::isSubmit('delete_id_group')
        ) {
            if(Tools::isSubmit('submitGroup')){
                $name= str_replace("'","\'",Tools::getValue('name'));
                if($this->existGroup($name)){
                    $error=$this->getTranslator()->trans('Name exists already .', array(), 'Modules.kj_store.Admin');
                }
                if(empty($name)){
                    $error=$this->getTranslator()->trans('Please set a correct name .', array(), 'Modules.kj_store.Admin');
                    $this->_html .= $this->displayError($error);
                }
                if(isset($error)){
                    $this->_html .= $this->displayError($error);
                    $this->_html .= $this->renderAddForm();
                    return $this->_html;
                }
                $group = new kj_store_object();
                $group->name=$name;
                $group->save();
            }else{
               $id=Tools::getValue('delete_id_group');
               $group = new kj_store_object($id);
               $group->delete();
            }
            $this->_html .= $this->renderList();
            return $this->_html;
        }
        if (Tools::isSubmit('addGroup')){
            $this->_html .= $this->renderAddForm();
            return $this->_html;
        }
        $this->_html .= $this->renderList();
        return $this->_html;
    }


    public function renderList(){
        $groups = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
                 Select * from `'._DB_PREFIX_.'group_store`
        ');
        $this->context->smarty->assign(
            array(
                'link' => $this->context->link,
                'groups' => $groups,
            )
        );

        return $this->display(__FILE__, 'list.tpl');
    }

    public function renderAddForm(){
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->getTranslator()->trans('Group information', array(), 'Modules.kj_store.Admin'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->getTranslator()->trans('Name', array(), 'Modules.Imageslider.Admin'),
                        'name' => 'name',
                        'Modules.Imageslider.Admin')
                    ),
                'submit' => array(
                    'title' => $this->getTranslator()->trans('Save', array(), 'Admin.Actions'),
                )
            )

        );

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitGroup';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getAddFieldsValues(),
        );

        return $helper->generateForm(array($fields_form));
    }

    public function getAddFieldsValues(){
        $fields = array();
        $fields['name']= Tools::getValue('name');
        return $fields;
    }

    public function existGroup($name){
       $count= Db::getInstance()->executeS("
        Select count(`id_group_store`) as `nbGroup` from `"._DB_PREFIX_."group_store` where `name` = '".strtolower($name)."'
        ");
       if($count[0]['nbGroup']>0){
           return true;
       }
       return false;
    }
}