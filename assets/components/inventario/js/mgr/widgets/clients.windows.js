Inventario.window.CreateClient = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'inventario-clients-window-create';
    }
    Ext.applyIf(config, {
        title: _('inventario_client_create'),
        width: 550,
        autoHeight: true,
        url: Inventario.config.connector_url,
        action: 'mgr/client/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    Inventario.window.CreateClient.superclass.constructor.call(this, config);
};
Ext.extend(Inventario.window.CreateClient, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'textfield',
            fieldLabel: _('inventario_client_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'xdatetime',
            fieldLabel: _('inventario_birthday'),
            name: 'birthday',
            id: config.id + '-birthday',
            anchor: '99%',
            allowBlank: true,
        }, {
            xtype: 'modx-combo-browser',
            fieldLabel: _('inventario_photo'),
            name: 'photo',
            id: config.id + '-photo',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('inventario_contact'),
            name: 'contact',
            id: config.id + '-contact',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('inventario_email'),
            name: 'email',
            id: config.id + '-email',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('inventario_phone'),
            name: 'phone',
            id: config.id + '-phone',
            anchor: '99%'
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
Ext.reg('inventario-clients-window-create', Inventario.window.CreateClient);


Inventario.window.UpdateClient = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'inventario-clients-window-update';
    }
    Ext.applyIf(config, {
        title: _('inventario_client_update'),
        width: 550,
        autoHeight: true,
        url: Inventario.config.connector_url,
        action: 'mgr/client/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    Inventario.window.UpdateClient.superclass.constructor.call(this, config);
};
Ext.extend(Inventario.window.UpdateClient, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'textfield',
            fieldLabel: _('inventario_client_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'xdatetime',
            fieldLabel: _('inventario_birthday'),
            name: 'birthday',
            id: config.id + '-birthday',
            anchor: '99%',
            allowBlank: true,
        }, {
            xtype: 'modx-combo-browser',
            fieldLabel: _('inventario_photo'),
            name: 'photo',
            id: config.id + '-photo',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('inventario_contact'),
            name: 'contact',
            id: config.id + '-contact',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('inventario_email'),
            name: 'email',
            id: config.id + '-email',
            anchor: '99%'
        }, {
            xtype: 'textfield',
            fieldLabel: _('inventario_phone'),
            name: 'phone',
            id: config.id + '-phone',
            anchor: '99%'
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
Ext.reg('inventario-clients-window-update', Inventario.window.UpdateClient);