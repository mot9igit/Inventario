<?php
$corePath = $modx->getOption('inventario_core_path', array(), $modx->getOption('core_path') . 'components/inventario/');
$Inventario = $modx->getService('Inventario', 'Inventario', $corePath . 'model/', $scriptProperties);
if (!$Inventario) {
	return 'Could not load Inventario class!';
}

if (!$modx->loadClass('pdofetch', MODX_CORE_PATH . 'components/pdotools/model/pdotools/', false, true)) {
	return false;
}
$pdoFetch = new pdoFetch($modx, $scriptProperties);

$id = $modx->user->id;
$out = array();

// todo: check usergroup access
if($id){
	$criteria = array(
		"user_id" => $id
	);
	$groups = $modx->getCollection("InventarioGroups");

	if($groups){
		foreach($groups as $group){
			$out['groups'][] = $group->toArray();
		}
	}
}

$output = $pdoFetch->getChunk($tpl, $out);
return $output;