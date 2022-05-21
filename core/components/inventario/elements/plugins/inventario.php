<?php
$scriptProperties = array();
$corePath = $modx->getOption('inventario_core_path', array(), $modx->getOption('core_path') . 'components/inventario/');
$Inventario = $modx->getService('Inventario', 'Inventario', $corePath . 'model/', $scriptProperties);
/** @var modX $modx */
switch ($modx->event->name) {
	case 'OnLoadWebDocument':
		if (!$Inventario) {
			$modx->log(1, 'Could not load Inventario class!');
		}else{
			$Inventario->initialize($modx->context->key);
		}
		break;
}