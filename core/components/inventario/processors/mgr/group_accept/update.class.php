<?php

class InventarioGroupsAcceptedUpdateProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'InventarioGroupsAccepted';
    public $classKey = 'InventarioGroupsAccepted';
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

        if (empty($id)) {
            return $this->modx->lexicon('inventario_group_acc_err_ns');
        }

		$group = trim($this->getProperty('group'));
		$ugroup = trim($this->getProperty('user_group'));
		if (empty($group) || empty($ugroup)) {
			$this->modx->error->addField('name', $this->modx->lexicon('inventario_group_acc_err_name'));
		} elseif ($this->modx->getCount($this->classKey, ['group' => $group, 'user_group' => $ugroup])) {
			$this->modx->error->addField('name', $this->modx->lexicon('inventario_group_acc_err_ae'));
		}

        return parent::beforeSet();
    }
}

return 'InventarioGroupsAcceptedUpdateProcessor';
