Inventario.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        /*
         stateful: true,
         stateId: 'inventario-panel-home',
         stateEvents: ['tabchange'],
         getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
         */
        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('inventario') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            items: [{
                title: _('inventario_items'),
                layout: 'anchor',
                items: [{
                    html: _('inventario_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'inventario-grid-items',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    Inventario.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(Inventario.panel.Home, MODx.Panel);
Ext.reg('inventario-panel-home', Inventario.panel.Home);
