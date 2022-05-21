<?php

class InventarioGroupsAcceptedCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'InventarioGroupsAccepted';
    public $classKey = 'InventarioGroupsAccepted';
    public $languageTopics = ['inventario'];
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $group = trim($this->getProperty('group'));
		$ugroup = trim($this->getProperty('user_group'));
        if (empty($group) || empty($ugroup)) {
            $this->modx->error->addField('name', $this->modx->lexicon('inventario_group_acc_err_name'));
        } elseif ($this->modx->getCount($this->classKey, ['group' => $group, 'user_group' => $ugroup])) {
            $this->modx->error->addField('name', $this->modx->lexicon('inventario_group_acc_err_ae'));
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

return 'InventarioGroupsAcceptedCreateProcessor';