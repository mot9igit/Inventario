<?php

class Inventario
{
    /** @var modX $modx */
    public $modx;


    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = [])
    {
		$this->modx =& $modx;
		$corePath = $this->modx->getOption('inventario_core_path', $config, $this->modx->getOption('core_path') . 'components/inventario/');
		$assetsUrl = $this->modx->getOption('inventario_assets_url', $config, $this->modx->getOption('assets_url') . 'components/inventario/');
		$assetsPath = $this->modx->getOption('inventario_assets_path', $config, $this->modx->getOption('base_path') . 'assets/components/inventario/');

        $this->config = array_merge([
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'processorsPath' => $corePath . 'processors/',
            'version' => '0.0.1',
            'connectorUrl' => $assetsUrl . 'connector.php',
            'assetsUrl' => $assetsUrl,
			'actionUrl' => $assetsUrl . 'action.php',
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',
        ], $config);

        $this->modx->addPackage('inventario', $this->config['modelPath']);
        $this->modx->lexicon->load('inventario:default');

		if ($this->pdoTools = $this->modx->getService('pdoFetch')) {
			$this->pdoTools->setConfig($this->config);
		}
    }

	/**
	 * Initializes component into different contexts.
	 *
	 * @param string $ctx The context to load. Defaults to web.
	 * @param array $scriptProperties Properties for initialization.
	 *
	 * @return bool
	 */
	public function initialize($ctx = 'web', $scriptProperties = array())
	{
		if (isset($this->initialized[$ctx])) {
			return $this->initialized[$ctx];
		}
		$this->config = array_merge($this->config, $scriptProperties);
		$this->config['ctx'] = $ctx;
		$this->modx->lexicon->load('inventario:default');

		if ($ctx != 'mgr' && (!defined('MODX_API_MODE') || !MODX_API_MODE) && !$this->config['json_response']) {
			$config = $this->pdoTools->makePlaceholders($this->config);
			// Register CSS
			$css = trim($this->modx->getOption('inventario_frontend_css'));
			if (!empty($css) && preg_match('/\.css/i', $css)) {
				if (preg_match('/\.css$/i', $css)) {
					$css .= '?v=' . substr(md5($this->config['version']), 0, 10);
				}
				$this->modx->regClientCSS(str_replace($config['pl'], $config['vl'], $css));
			}

			// Register JS
			$js = trim($this->modx->getOption('inventario_frontend_js'));
			if (!empty($js) && preg_match('/\.js/i', $js)) {
				if (preg_match('/\.js$/i', $js)) {
					$js .= '?v=' . substr(md5($this->config['version']), 0, 10);
				}
				$this->modx->regClientScript(str_replace($config['pl'], $config['vl'], $js));


				$js_setting = array(
					'cssUrl' => $this->config['cssUrl'] . 'web/',
					'jsUrl' => $this->config['jsUrl'] . 'web/',
					'actionUrl' => $this->config['actionUrl'],
					'ctx' => $ctx
				);

				$data = json_encode($js_setting, true);
				$this->modx->regClientStartupScript(
					'<script>inventarioConfig = ' . $data . ';</script>',
					true
				);
			}
		}
		$this->initialized[$ctx] = true;

		return $this->initialized[$ctx];
	}

	/**
	 * Handle frontend requests with actions
	 *
	 * @param $action
	 * @param array $data
	 *
	 * @return array|bool|string
	 */
	public function handleRequest($action, $data = array())
	{
		$ctx = !empty($data['ctx'])
			? (string)$data['ctx']
			: 'web';
		if ($ctx != 'web') {
			$this->modx->switchContext($ctx);
		}
		$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
		$this->initialize($ctx, array('json_response' => $isAjax));
		switch ($action) {
			case 'p_filter/set':
				$response = $this->p_filter($data);
				break;
			case 'object/remove':
				$response = $this->remainRemove($data);
				break;
			case 'object/edit':
				$response = $this->remainUpdate($data);
				break;
			case 'client_filter/set':
				$response = $this->client_filter($data);
				break;
			case 'client/remove':
				$response = $this->clientRemove($data);
				break;
			case 'client/edit':
				$response = $this->clientUpdate($data);
				break;
		}
		return $response;
	}

	public function p_filter($data){
		// check this user == 0
		$access = true;
		$this->modx->log(1, $this->modx->user->id);
		if($this->modx->user->isMember('Administrator')){
			$access = true;
		}
		$criteria = array(
			'group' => $data['col_id']
		);
		$objs = $this->modx->getCollection('InventarioGroupsAccepted', $criteria);
		foreach($objs as $obj){
			$group = $this->modx->getObject("modUserGroup", $obj->get("user_group"));
			if($group){
				if($this->modx->user->isMember($group->get('name'))){
					$access = true;
				}
			}
		}
		if($access){
			$b_criteria = array(
				'element' => 'i.objects',
				'parents' => 0,
				'limit' => 10,
				'col_id' => $data['col_id'],
				"tpl" => "@FILE chunks/i_objects.tpl",
				'tplPage' => '@INLINE <li class="page-item"><a class="page-link" href="{$href}" data-number="{$pageNo}">{$pageNo}</a></li>',
				'tplPageWrapper' => '@INLINE  <nav><ul class="pagination justify-content-center">{$prev}{$pages}{$next}</ul></nav>',
				'tplPageActive' => '@INLINE <li class="page-item active"><a class="page-link" href="{$href}" data-number="{$pageNo}">{$pageNo}</a></li>',
				'tplPagePrev' => '@INLINE <li class="page-item"><a class="page-link" href="{$href}" aria-label="Previous" data-number="{$pageNo}"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>',
				'tplPageNext' => '@INLINE <li class="page-item"><a class="page-link" href="{$href}" aria-label="Next" data-number="{$pageNo}"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>',
				'tplPagePrevEmpty' => '@INLINE ',
				'tplPageNextEmpty' => '@INLINE '
			);
			if($data['col_id']){
				$b_criteria['where'][] = array(
					'group' => $data['col_id'],
				);
			}
			if($data['only_remains']){
				$ids = array();
				$criteria = array(
					'count:>' => 0
				);
				$cols = $this->modx->getCollection('InventarioItems', $criteria);
				foreach($cols as $col){
					$ids[] = $col->get('id');
				}
				$b_criteria['where'][] = "InventarioItems.id IN (".implode(',', $ids).')';
			}
			if($data['name']){
				if(count($b_criteria['where'])){
					$b_criteria['where'][] = array(
						"name:LIKE" => '%'.$data['name'].'%',
						"OR:number:LIKE" => '%'.$data['name'].'%',
					);
				}else{
					$b_criteria['where'] = array(
						"name:LIKE" => '%'.$data['name'].'%',
						"OR:number:LIKE" => '%'.$data['name'].'%',
					);
				}
			}
			$out = array();
			$_SESSION['i_filters'][$data['spage'].'_'.$data['col_id']] = $b_criteria['where'];
			$out['data'] = $this->modx->runSnippet("pdoPage", $b_criteria);
			$out['pagination'] = $this->modx->getPlaceholder('page.nav');
			$out['total'] = $this->modx->getPlaceholder('page.total');
			$out['topdo'] = 1;
			return $out;
		}else{
			return $this->error('<div class="alert alert-error">Нет доступа к этой группе</div>', array('col_id' => $data['col_id']));
		}
	}

	public function client_filter($data){
		// check this user == 0
		$access = true;
		$this->modx->log(1, $this->modx->user->id);
		if($this->modx->user->isMember('Administrator')){
			$access = true;
		}
		$criteria = array(
			'group' => $data['col_id']
		);
		$objs = $this->modx->getCollection('InventarioGroupsAccepted', $criteria);
		foreach($objs as $obj){
			$group = $this->modx->getObject("modUserGroup", $obj->get("user_group"));
			if($group){
				if($this->modx->user->isMember($group->get('name'))){
					$access = true;
				}
			}
		}
		if($access){
			$b_criteria = array(
				'element' => 'i.clients',
				'parents' => 0,
				'limit' => 10,
				"tpl" => "@FILE chunks/i_client.tpl",
				'tplPage' => '@INLINE <li class="page-item"><a class="page-link" href="{$href}" data-number="{$pageNo}">{$pageNo}</a></li>',
				'tplPageWrapper' => '@INLINE  <nav><ul class="pagination justify-content-center">{$prev}{$pages}{$next}</ul></nav>',
				'tplPageActive' => '@INLINE <li class="page-item active"><a class="page-link" href="{$href}" data-number="{$pageNo}">{$pageNo}</a></li>',
				'tplPagePrev' => '@INLINE <li class="page-item"><a class="page-link" href="{$href}" aria-label="Previous" data-number="{$pageNo}"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>',
				'tplPageNext' => '@INLINE <li class="page-item"><a class="page-link" href="{$href}" aria-label="Next" data-number="{$pageNo}"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>',
				'tplPagePrevEmpty' => '@INLINE ',
				'tplPageNextEmpty' => '@INLINE '
			);
			if($data['name']){
				if(count($b_criteria['where'])){
					$b_criteria['where'][] = array(
						"name:LIKE" => '%'.$data['name'].'%',
						"OR:phone:LIKE" => '%'.$data['name'].'%',
						"OR:email:LIKE" => '%'.$data['name'].'%',
					);
				}else{
					$b_criteria['where'] = array(
						"name:LIKE" => '%'.$data['name'].'%',
						"OR:phone:LIKE" => '%'.$data['name'].'%',
						"OR:email:LIKE" => '%'.$data['name'].'%',
					);
				}
			}
			$out = array();
			$_SESSION['i_filters'][$data['spage']] = $b_criteria['where'];
			$out['data'] = $this->modx->runSnippet("pdoPage", $b_criteria);
			$out['pagination'] = $this->modx->getPlaceholder('page.nav');
			$out['total'] = $this->modx->getPlaceholder('page.total');
			$out['topdo'] = 1;
			return $out;
		}else{
			return $this->error('<div class="alert alert-error">Нет доступа к этой группе</div>', array());
		}
	}

	public function clientRemove($data){
		if($data['id']){
			$client = $this->modx->getObject('InventarioClients', $data['id']);
			if($client){
				$client->remove();
				return $this->success('<div class="sl-alert sl-alert-success">Клиент успешно удален</div>', array('remove_id' => $data['id']));
			}else{
				return $this->error('<div class="alert alert-error">Клиент не найден</div>', array('remove_id' => $data['id']));
			}
		}else{
			return $this->error('<div class="alert alert-error">Параметр ID не определен</div>', array('remove_id' => $data['id']));
		}
	}

	public function clientUpdate($data){
		if($data['id']){
			$client = $this->modx->getObject('InventarioClients', $data['id']);
			if($client){
				$dt = array("name", "birthday", "photo", "contact", "email", "phone", "description");
				foreach($data as $key => $item){
					if(in_array($key, $dt)){
						if($key == 'birthday'){
							$date = strtotime(str_replace(".", "-", $item));
							$client->set($key, date('Y-m-d H:i:s', $date));
						}else{
							$client->set($key, $item);
						}
					}
				}
				if(!empty($_FILES['photo'])){
					$ph = $this->setImage($_FILES, $data['id']);
					if($ph){
						$old_file = $this->modx->getOption('base_path').'userfiles/inventario/clients/'.$data['id'].'/'.$client->get('photo');
						unlink($old_file);
						$client->set('photo', $ph);
					}
				}
				$client->set('editedby', $this->modx->user->get('id'));
				$client->set('editedon', time(), 'integer');
				$client->save();
				$data = $client->toArray();
				$data['type'] = 'client';
				return $this->success('<div class="alert alert-success">Клиент успешно сохранен</div>', $data);
			}else{
				return $this->error('<div class="alert alert-error">Клиент не найден</div>', array('id' => $data['id']));
			}
		}else{
			// add new object
			$client = $this->modx->newObject('InventarioClients');
			$dt = array("name", "birthday", "photo", "contact", "email", "phone", "description");
			foreach($data as $key => $item){
				if(in_array($key, $dt)){
					$client->set($key, $item);
				}
			}
			$client->set('createdby', $this->modx->user->get('id'));
			$client->set('createdon', time(), 'integer');
			$client->save();
			if(!empty($_FILES['photo'])){
				$ph = $this->setImage($_FILES, $client->get('id'), 'clients');
				if($ph){
					$client->set('photo', $ph);
					$client->save();
				}
			}
			$data = $client->toArray();
			$data['type'] = 'client';
			return $this->success('<div class="alert alert-success">Клиент успешно создан</div>', $data);
		}
	}

	public function remainRemove($data){
		if($data['id']){
			$remain = $this->modx->getObject('InventarioItems', $data['id']);
			if($remain){
				$remain->remove();
				return $this->success('<div class="sl-alert sl-alert-success">Остаток успешно удален</div>', array('remove_id' => $data['id']));
			}else{
				return $this->error('<div class="alert alert-error">Объект не найден</div>', array('remove_id' => $data['id']));
			}
		}else{
			return $this->error('<div class="alert alert-error">Параметр ID не определен</div>', array('remove_id' => $data['id']));
		}
	}

	public function remainUpdate($data){
		if($data['id']){
			$remain = $this->modx->getObject($data['type'], $data['id']);
			if($remain){
				$dt = array("name", "photo", "number", "count", "description");
				foreach($data as $key => $item){
					if(in_array($key, $dt)){
						$remain->set($key, $item);
					}
				}
				if(!empty($_FILES['photo'])){
					$ph = $this->setImage($_FILES, $data['id']);
					if($ph){
						$old_file = $this->modx->getOption('base_path').'userfiles/inventario/objects/'.$data['id'].'/'.$remain->get('photo');
						unlink($old_file);
						$remain->set('photo', $ph);
					}
				}
				$remain->set('editedby', $this->modx->user->get('id'));
				$remain->set('editedon', time(), 'integer');
				$remain->save();
				$data = $remain->toArray();
				$data['type'] = 'object';
				return $this->success('<div class="alert alert-success">Объект успешно сохранен</div>', $data);
			}else{
				return $this->error('<div class="alert alert-error">Объект не найден</div>', array('id' => $data['id']));
			}
		}else{
			// add new object
			$remain = $this->modx->newObject($data['type']);
			$dt = array("name", "group", "number", "count", "description");
			foreach($data as $key => $item){
				if(in_array($key, $dt)){
					$remain->set($key, $item);
				}
			}
			$remain->set('createdby', $this->modx->user->get('id'));
			$remain->set('createdon', time(), 'integer');
			$remain->save();
			if(!empty($_FILES['photo'])){
				$ph = $this->setImage($_FILES, $remain->get('id'));
				if($ph){
					$remain->set('photo', $ph);
					$remain->save();
				}
			}
			$data = $remain->toArray();
			$data['type'] = 'object';
			return $this->success('<div class="alert alert-success">Объект успешно создан</div>', $data);
		}
	}

	public function setImage($files, $id, $type = 'objects'){
		$this->modx->log(1, print_r($files, 1));
		$uploaddir = $this->modx->getOption('base_path').'userfiles/inventario/'.$type.'/'.$id.'/';
		$uploadfile = $uploaddir . basename($files['photo']['name']);
		$file = 'inventario/'.$type.'/'.$id.'/'.basename($files['photo']['name']);
		if (!file_exists($uploaddir)) {
			mkdir($uploaddir, 0755);
		}
		if (move_uploaded_file($files['photo']['tmp_name'], $uploadfile)) {
			return $file;
		}else{
			return false;
		}
	}

	/**
	 * @return bool
	 */
	public function isAjaxRequest()
	{
		if (
			isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
			strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
		) {
			return true;
		}
		return false;
	}

	/**
	 * @return false
	 */
	public function isAjaxRequestInAssets()
	{
		if (!$this->isAjaxRequest()) return false;
		$assetsUrl = $this->modx->getOption('assets_url', null, MODX_ASSETS_URL);
		$assetsUrl = preg_quote($assetsUrl, '/');
		return (bool)preg_match("/^{$assetsUrl}/", $_SERVER['REQUEST_URI']);

	}

	/**
	 * This method returns an error of the order
	 *
	 * @param string $message A lexicon key for error message
	 * @param array $data .Additional data, for example cart status
	 * @param array $placeholders Array with placeholders for lexicon entry
	 *
	 * @return array|string $response
	 */
	public function error($message = '', $data = array(), $placeholders = array())
	{
		$response = array(
			'success' => false,
			//'message' => $this->modx->lexicon($message, $placeholders),
			'message' => $message,
			'data' => $data,
		);

		return $this->config['json_response']
			? json_encode($response)
			: $response;
	}


	/**
	 * This method returns an success of the order
	 *
	 * @param string $message A lexicon key for success message
	 * @param array $data .Additional data, for example cart status
	 * @param array $placeholders Array with placeholders for lexicon entry
	 *
	 * @return array|string $response
	 */
	public function success($message = '', $data = array(), $placeholders = array())
	{
		$response = array(
			'success' => true,
			//'message' => $this->modx->lexicon($message, $placeholders),
			'message' => $message,
			'data' => $data,
		);

		return $this->config['json_response']
			? json_encode($response)
			: $response;
	}
}