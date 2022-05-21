Inventario.window.CreateAcc = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'inventario-acc-window-create';
    }
    Ext.applyIf(config, {
        title: _('inventario_acc_create'),
        width: 550,
        autoHeight: true,
        url: Inventario.config.connector_url,
        action: 'mgr/group_accept/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    Inventario.window.CreateAcc.superclass.constructor.call(this, config);
};
Ext.extend(Inventario.window.CreateAcc, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'inventario-combo-ugroups',
            fieldLabel: _('inventario_user_group'),
            name: 'user_group',
            id: config.id + '-user_group',
            anchor: '99%'
        }, {
            xtype: 'inventario-combo-groups',
            fieldLabel: _('inventario_group'),
            name: 'group',
            id: config.id + '-group',
            anchor: '99%'
        }, {
            xtype: 'textarea',
            fieldLabel: _('inventario_description'),
            name: 'description',
            id: config.id + '-description',
            height: 150,
            anchor: '99%'
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('inventario-acc-window-create', Inventario.window.CreateAcc);


Inventario.window.UpdateAcc = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'inventario-acc-window-update';
    }
    Ext.applyIf(config, {
        title: _('inventario_acc_update'),
        width: 550,
        autoHeight: true,
        url: Inventario.config.connector_url,
        action: 'mgr/group_accept/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    Inventario.window.UpdateAcc.superclass.constructor.call(this, config);
};
Ext.extend(Inventario.window.UpdateAcc, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'inventario-combo-ugroups',
            fieldLabel: _('inventario_user_group'),
            name: 'user_group',
            id: config.id + '-user_group',
            anchor: '99%'
        }, {
            xtype: 'inventario-combo-groups',
            fieldLabel: _('inventario_group'),
            name: 'group',
            id: config.id + '-group',
            anchor: '99%'
        }, {
            xtype: 'textarea',
            fieldLabel: _('inventario_description'),
            name: 'description',
            id: config.id + '-description',
            height: 150,
            anchor: '99%'
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('inventario-acc-window-update', Inventario.window.UpdateAcc);