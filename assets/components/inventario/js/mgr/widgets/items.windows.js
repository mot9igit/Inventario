Inventario.window.CreateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'inventario-item-window-create';
    }
    Ext.applyIf(config, {
        title: _('inventario_item_create'),
        width: 550,
        autoHeight: true,
        url: Inventario.config.connector_url,
        action: 'mgr/item/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    Inventario.window.CreateItem.superclass.constructor.call(this, config);
};
Ext.extend(Inventario.window.CreateItem, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'textfield',
            fieldLabel: _('inventario_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        },{
            xtype: 'textfield',
            fieldLabel: _('inventario_number'),
            name: 'number',
            id: config.id + '-number',
            anchor: '99%',
            allowBlank: false,
        },{
            xtype: 'numberfield',
            fieldLabel: _('inventario_count'),
            name: 'count',
            id: config.id + '-count',
            anchor: '99%'
        }, {
            xtype: 'modx-combo-browser',
            fieldLabel: _('inventario_photo'),
            name: 'photo',
            id: config.id + '-photo',
            anchor: '99%'
        }, {
            xtype: 'inventario-combo-groups',
            fieldLabel: _('inventario_group'),
            name: 'group',
            id: config.id + '-group',
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
Ext.reg('inventario-item-window-create', Inventario.window.CreateItem);


Inventario.window.UpdateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'inventario-item-window-update';
    }
    Ext.applyIf(config, {
        title: _('inventario_item_update'),
        width: 550,
        autoHeight: true,
        url: Inventario.config.connector_url,
        action: 'mgr/item/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    Inventario.window.UpdateItem.superclass.constructor.call(this, config);
};
Ext.extend(Inventario.window.UpdateItem, MODx.Window, {

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
        },{
            xtype: 'textfield',
            fieldLabel: _('inventario_number'),
            name: 'number',
            id: config.id + '-number',
            anchor: '99%',
            allowBlank: false,
        },{
            xtype: 'numberfield',
            fieldLabel: _('inventario_count'),
            name: 'count',
            id: config.id + '-count',
            anchor: '99%'
        }, {
            xtype: 'modx-combo-browser',
            fieldLabel: _('inventario_photo'),
            name: 'photo',
            id: config.id + '-photo',
            anchor: '99%'
        }, {
            xtype: 'inventario-combo-groups',
            fieldLabel: _('inventario_group'),
            name: 'group',
            id: config.id + '-group',
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
Ext.reg('inventario-item-window-update', Inventario.window.UpdateItem);