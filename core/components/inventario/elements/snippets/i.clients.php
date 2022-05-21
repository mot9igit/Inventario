<?php
$corePath = $modx->getOption('inventario_core_path', array(), $modx->getOption('core_path') . 'components/inventario/');
$Inventario = $modx->getService('Inventario', 'Inventario', $corePath . 'model/', $scriptProperties);
if (!$Inventario) {
	//return 'Could not load Inventario class!';
}

/** @var pdoFetch $pdoFetch */
$fqn = $modx->getOption('pdoFetch.class', null, 'pdotools.pdofetch', true);
$path = $modx->getOption('pdofetch_class_path', null, MODX_CORE_PATH . 'components/pdotools/model/', true);
if ($pdoClass = $modx->loadClass($fqn, $path, false, true)) {
	$pdoFetch = new $pdoClass($modx, $scriptProperties);
} else {
	//return false;
}
$pdoFetch->addTime('pdoTools loaded.');

if (!empty($returnIds)) {
	$scriptProperties['return'] = 'ids';
}

if ($scriptProperties['return'] === 'ids') {
	$scriptProperties['returnIds'] = true;
}

// Start build "where" expression
if($_GET['col_id']){
	$where = array(
		//"group" => $_GET['col_id']
	);
}

// Add grouping
$groupby = array(
	'InventarioClients.id',
);

// Join tables
$leftJoin = array(
);

$select = array(
	'InventarioClients' => $modx->getSelectColumns('InventarioClients', 'InventarioClients')
);


//$modx->log(1, $_REQUEST['pageId'] . '_' . $scriptProperties['col_id']);
//$modx->log(1, print_r($_SESSION['i_filters'][$_REQUEST['pageId'] . '_' . $scriptProperties['col_id']], 1));

if ($_REQUEST['pageId']) {
	if ($_SESSION['i_filters'][$_REQUEST['spage']]) {
		$scriptProperties['where'] = $_SESSION['i_filters'][$_REQUEST['spage']];
	}
}

// Add user parameters
foreach (array('where') as $v) {
	if (!empty($scriptProperties[$v])) {
		$tmp = $scriptProperties[$v];
		if (!is_array($tmp)) {
			$tmp = json_decode($tmp, true);
		}
		if (is_array($tmp)) {
			$$v = array_merge($$v, $tmp);
		}
	}
	unset($scriptProperties[$v]);
}
$pdoFetch->addTime('Conditions prepared');

$default = array(
	'class' => 'InventarioClients',
	'where' => $where,
	'select' => $select,
	'sortby' => 'InventarioClients.id',
	'sortdir' => 'ASC',
	'groupby' => implode(', ', $groupby),
	'return' => 'data',
	'nestedChunkPrefix' => 'minishop2_',
);
// Merge all properties and run!
$pdoFetch->setConfig(array_merge($default, $scriptProperties), false);
$rows = $pdoFetch->run();

// Process rows
$output = array();
if (!empty($rows) && is_array($rows)) {

	$opt_time = 0;
	foreach ($rows as $k => $row) {

		$row['idx'] = $pdoFetch->idx++;

		$tpl = $pdoFetch->defineChunk($row);
		$output[] = $pdoFetch->getChunk($tpl, $row);
	}
	$pdoFetch->addTime('Time to load products options', $opt_time);
}

$log = '';
if ($modx->user->hasSessionContext('mgr') && !empty($showLog)) {
	$log .= '<pre class="msProductsLog">' . print_r($pdoFetch->getTime(), 1) . '</pre>';
}

// Return output
if (is_string($rows)) {
	$modx->setPlaceholder('msProducts.log', $log);
	if (!empty($toPlaceholder)) {
		$modx->setPlaceholder($toPlaceholder, $rows);
	} else {
		return $rows;
	}
} elseif (!empty($toSeparatePlaceholders)) {
	$output['log'] = $log;
	$modx->setPlaceholders($output, $toSeparatePlaceholders);
} else {
	if (empty($outputSeparator)) {
		$outputSeparator = "\n";
	}
	$output['log'] = $log;
	$output = implode($outputSeparator, $output);

	if (!empty($tplWrapper) && (!empty($wrapIfEmpty) || !empty($output))) {
		$output = $pdoFetch->getChunk($tplWrapper, array(
			'output' => $output,
		));
	}

	if (!empty($toPlaceholder)) {
		$modx->setPlaceholder($toPlaceholder, $output);
	} else {
		return $output;
	}
}