<?php

class InventarioClientsDisableProcessor extends modObjectProcessor
{
    public $objectType = 'InventarioClients';
    public $classKey = 'InventarioClients';
    public $languageTopics = ['inventario'];
    //public $permission = 'save';


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
            return $this->failure($this->modx->lexicon('inventario_client_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var InventarioItem $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('inventario_client_err_nf'));
            }

            $object->set('active', false);
			$object->set('editedby', $this->modx->user->get('id'));
			$object->set('editedon', time(), 'integer');
            $object->save();
        }

        return $this->success();
    }

}

return 'InventarioClientsDisableProcessor';
