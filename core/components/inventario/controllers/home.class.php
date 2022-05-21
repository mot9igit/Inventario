<?php

/**
 * The home manager controller for Inventario.
 *
 */
class InventarioHomeManagerController extends modExtraManagerController
{
    /** @var Inventario $Inventario */
    public $Inventario;


    /**
     *
     */
    public function initialize()
    {
		$corePath = $this->modx->getOption('inventario_core_path', array(), $this->modx->getOption('core_path') . 'components/inventario/');
        $this->Inventario = $this->modx->getService('Inventario', 'Inventario', $corePath . 'model/');
        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return ['inventario:default'];
    }


    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('inventario');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->Inventario->config['cssUrl'] . 'mgr/main.css');
        $this->addJavascript($this->Inventario->config['jsUrl'] . 'mgr/inventario.js');
        $this->addJavascript($this->Inventario->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->Inventario->config['jsUrl'] . 'mgr/misc/combo.js');
		$this->addJavascript($this->Inventario->config['jsUrl'] . 'mgr/widgets/acc.grid.js');
		$this->addJavascript($this->Inventario->config['jsUrl'] . 'mgr/widgets/acc.windows.js');
		$this->addJavascript($this->Inventario->config['jsUrl'] . 'mgr/widgets/clients.grid.js');
		$this->addJavascript($this->Inventario->config['jsUrl'] . 'mgr/widgets/clients.windows.js');
		$this->addJavascript($this->Inventario->config['jsUrl'] . 'mgr/widgets/groups.grid.js');
		$this->addJavascript($this->Inventario->config['jsUrl'] . 'mgr/widgets/groups.windows.js');
        $this->addJavascript($this->Inventario->config['jsUrl'] . 'mgr/widgets/items.grid.js');
        $this->addJavascript($this->Inventario->config['jsUrl'] . 'mgr/widgets/items.windows.js');
        $this->addJavascript($this->Inventario->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addJavascript($this->Inventario->config['jsUrl'] . 'mgr/sections/home.js');

        $this->addHtml('<script type="text/javascript">
        Inventario.config = ' . json_encode($this->Inventario->config) . ';
        Inventario.config.connector_url = "' . $this->Inventario->config['connectorUrl'] . '";
        Ext.onReady(function() {MODx.load({ xtype: "inventario-page-home"});});
        </script>');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        $this->content .= '<div id="inventario-panel-home-div"></div>';
        return '';
    }
}