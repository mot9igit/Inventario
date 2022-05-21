<?php

class InventarioUGroupGetListProcessor extends modObjectGetListProcessor
{
	public $objectType = 'modUserGroup';
	public $classKey = 'modUserGroup';
	public $defaultSortField = 'id';
	public $defaultSortDirection = 'DESC';
	//public $permission = 'list';


	/**
	 * We do a special check of permissions
	 * because our objects is not an instances of modAccessibleObject
	 *
	 * @return boolean|string
	 */
	public function beforeQuery()
	{
		if (!$this->checkPermissions()) {
			return $this->modx->lexicon('access_denied');
		}

		return true;
	}
}

return 'InventarioUGroupGetListProcessor';