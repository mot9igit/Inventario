<?php

class InventarioClientsUpdateProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'InventarioClients';
    public $classKey = 'InventarioClients';
    public $languageTopics = ['inventario'];
    //public $permission = 'save';


    /**
     * We doing special check of permission
     * because of our objects is not an instances of modAccessibleObject
     *
     * @return bool|string
     */
    public function beforeSave()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }
		$this->object->set('editedby', $this->modx->user->get('id'));
		$this->object->set('editedon', time(), 'integer');
		return parent::beforeSave();
    }


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $id = (int)$this->getProperty('id');
        $name = trim($this->getProperty('name'));
        if (empty($id)) {
            return $this->modx->lexicon('inventario_client_err_ns');
        }

        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('inventario_group_err_name'));
        } elseif ($this->modx->getCount($this->classKey, ['name' => $name, 'id:!=' => $id])) {
            $this->modx->error->addField('name', $this->modx->lexicon('inventario_group_err_ae'));
        }

        return parent::beforeSet();
    }
}

return 'InventarioClientsUpdateProcessor';
