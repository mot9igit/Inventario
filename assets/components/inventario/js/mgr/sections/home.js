Inventario.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'inventario-panel-home',
            renderTo: 'inventario-panel-home-div'
        }]
    });
    Inventario.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(Inventario.page.Home, MODx.Component);
Ext.reg('inventario-page-home', Inventario.page.Home);