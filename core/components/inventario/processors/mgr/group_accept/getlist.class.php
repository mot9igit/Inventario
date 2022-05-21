<?php

class InventarioGroupsAcceptedGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'InventarioGroupsAccepted';
    public $classKey = 'InventarioGroupsAccepted';
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


    /**
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $query = trim($this->getProperty('query'));
        if ($query) {
            $c->where([
                'name:LIKE' => "%{$query}%",
                'OR:description:LIKE' => "%{$query}%",
            ]);
        }

        return $c;
    }


    /**
     * @param xPDOObject $object
     *
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        $array = $object->toArray();
        $group = $array['group'];
        $obj = $this->modx->getObject("InventarioGroups", $group);
        if($obj){
			$array['group_name'] = $obj->get('name');
		}
		$user_group = $array['user_group'];
		$obj = $this->modx->getObject("modUserGroup", $user_group);
		if($obj){
			$array['usergroup_name'] = $obj->get('name');
		}
        $array['actions'] = [];

        // Edit
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-edit',
            'title' => $this->modx->lexicon('inventario_group_acc_update'),
            //'multiple' => $this->modx->lexicon('inventario_items_update'),
            'action' => 'updateItem',
            'button' => true,
            'menu' => true,
        ];

        // Remove
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('inventario_group_acc_remove'),
            'multiple' => $this->modx->lexicon('inventario_group_accs_remove'),
            'action' => 'removeItem',
            'button' => true,
            'menu' => true,
        ];

        return $array;
    }

}

return 'InventarioGroupsAcceptedGetListProcessor';