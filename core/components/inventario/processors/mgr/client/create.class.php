<?php

class InventarioClientsCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'InventarioClients';
    public $classKey = 'InventarioClients';
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

		$scriptProperties = $this->getProperties();
		if(empty($scriptProperties['createdon'])){
			$scriptProperties['createdon'] = strftime('%Y-%m-%d %H:%M:%S');
		}

		if(empty($scriptProperties['createdby'])){
			$scriptProperties['createdby'] = $this->modx->user->get('id');
		}

		$this->setProperties($scriptProperties);
        return parent::beforeSet();
    }

}

return 'InventarioClientsCreateProcessor';