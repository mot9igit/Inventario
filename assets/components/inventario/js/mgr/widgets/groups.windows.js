Inventario.window.CreateGroup = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'inventario-group-window-create';
    }
    Ext.applyIf(config, {
        title: _('inventario_group_create'),
        width: 550,
        autoHeight: true,
        url: Inventario.config.connector_url,
        action: 'mgr/group/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    Inventario.window.CreateGroup.superclass.constructor.call(this, config);
};
Ext.extend(Inventario.window.CreateGroup, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'textfield',
            fieldLabel: _('inventario_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textarea',
            fieldLabel: _('inventario_description'),
            name: 'description',
            id: config.id + '-description',
            height: 150,
            anchor: '99%'
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('inventario_active'),
            name: 'active',
            id: config.id + '-active',
            checked: true,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('inventario-group-window-create', Inventario.window.CreateGroup);


Inventario.window.UpdateGroup = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'inventario-group-window-update';
    }
    Ext.applyIf(config, {
        title: _('inventario_group_update'),
        width: 550,
        autoHeight: true,
        url: Inventario.config.connector_url,
        action: 'mgr/group/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    Inventario.window.UpdateGroup.superclass.constructor.call(this, config);
};
Ext.extend(Inventario.window.UpdateGroup, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'textfield',
            fieldLabel: _('inventario_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textarea',
            fieldLabel: _('inventario_description'),
            name: 'description',
            id: config.id + '-description',
            anchor: '99%',
            height: 150,
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('inventario_active'),
            name: 'active',
            id: config.id + '-active',
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('inventario-group-window-update', Inventario.window.UpdateGroup);