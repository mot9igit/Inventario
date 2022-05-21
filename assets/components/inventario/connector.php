<?php
if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php')) {
	/** @noinspection PhpIncludeInspection */
	require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
} else {
	require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/config.core.php';
}
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';
$corePath = $modx->getOption('inventario_core_path', null, $modx->getOption('core_path') . 'components/inventario/');
/** @var Inventario $Inventario */
$Inventario = $modx->getService('Inventario', 'Inventario', $corePath . 'model/');
$modx->lexicon->load('inventario:default');

// handle request
$corePath = $modx->getOption('inventario_core_path', null, $modx->getOption('core_path') . 'components/inventario/');
$path = $modx->getOption('processorsPath', $Inventario->config, $corePath . 'processors/');
$modx->getRequest();

/** @var modConnectorRequest $request */
$request = $modx->request;
$request->handleRequest([
    'processors_path' => $path,
    'location' => '',
]);