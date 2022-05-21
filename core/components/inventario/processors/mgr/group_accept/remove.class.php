<?php

class InventarioGroupsAcceptedRemoveProcessor extends modObjectProcessor
{
    public $objectType = 'InventarioGroupsAccepted';
    public $classKey = 'InventarioGroupsAccepted';
    public $languageTopics = ['inventario'];
    //public $permission = 'remove';


    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        $ids = $this->modx->fromJSON($this->getProperty('ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('inventario_group_acc_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var InventarioItem $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('inventario_group_acc_err_nf'));
            }

            $object->remove();
        }

        return $this->success();
    }

}

return 'InventarioGroupsAcceptedRemoveProcessor';