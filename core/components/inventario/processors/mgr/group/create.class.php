<?php

class InventarioGroupCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'InventarioGroups';
    public $classKey = 'InventarioGroups';
    public $languageTopics = ['inventario'];
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->getProperty('name'));
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('inventario_group_err_name'));
        } elseif ($this->modx->getCount($this->classKey, ['name' => $name])) {
            $this->modx->error->addField('name', $this->modx->lexicon('inventario_group_err_ae'));
        }

        return parent::beforeSet();
    }

}

return 'InventarioGroupCreateProcessor';