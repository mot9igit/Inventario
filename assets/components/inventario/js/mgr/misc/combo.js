Inventario.combo.ComboBoxDefault = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        assertValue : function () {
            var val = this.getRawValue(),
                rec;
            if (this.valueField && Ext.isDefined(this.value)) {
                rec = this.findRecord(this.valueField, this.value);
            }
            /* fix for https://github.com/bezumkin/miniShop2/pull/350
            if(!rec || rec.get(this.displayField) != val){
                rec = this.findRecord(this.displayField, val);
            }*/
            if (rec && rec.get(this.displayField) != val) {
                rec = null;
            }
            if (!rec && this.forceSelection) {
                if (val.length > 0 && val != this.emptyText) {
                    this.el.dom.value = Ext.value(this.lastSelectionText, '');
                    this.applyEmptyText();
                } else {
                    this.clearValue();
                }
            } else {
                if (rec && this.valueField) {
                    if (this.value == val) {
                        return;
                    }
                    val = rec.get(this.valueField || this.displayField);
                }
                this.setValue(val);
            }
        },

    });
    Inventario.combo.ComboBoxDefault.superclass.constructor.call(this, config);
};
Ext.extend(Inventario.combo.ComboBoxDefault, MODx.combo.ComboBox);
Ext.reg('inventario-combo-combobox-default', Inventario.combo.ComboBoxDefault);

Inventario.combo.Search = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        xtype: 'twintrigger',
        ctCls: 'x-field-search',
        allowBlank: true,
        msgTarget: 'under',
        emptyText: _('search'),
        name: 'query',
        triggerAction: 'all',
        clearBtnCls: 'x-field-search-clear',
        searchBtnCls: 'x-field-search-go',
        onTrigger1Click: this._triggerSearch,
        onTrigger2Click: this._triggerClear,
    });
    Inventario.combo.Search.superclass.constructor.call(this, config);
    this.on('render', function () {
        this.getEl().addKeyListener(Ext.EventObject.ENTER, function () {
            this._triggerSearch();
        }, this);
    });
    this.addEvents('clear', 'search');
};
Ext.extend(Inventario.combo.Search, Ext.form.TwinTriggerField, {

    initComponent: function () {
        Ext.form.TwinTriggerField.superclass.initComponent.call(this);
        this.triggerConfig = {
            tag: 'span',
            cls: 'x-field-search-btns',
            cn: [
                {tag: 'div', cls: 'x-form-trigger ' + this.searchBtnCls},
                {tag: 'div', cls: 'x-form-trigger ' + this.clearBtnCls}
            ]
        };
    },

    _triggerSearch: function () {
        this.fireEvent('search', this);
    },

    _triggerClear: function () {
        this.fireEvent('clear', this);
    },

});
Ext.reg('inventario-combo-search', Inventario.combo.Search);
Ext.reg('inventario-field-search', Inventario.combo.Search);

Inventario.combo.Groups = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        name: 'group',
        fieldLabel: config.name || 'group',
        hiddenName: config.name || 'group',
        displayField: 'name',
        valueField: 'id',
        anchor: '99%',
        fields: ['id', 'name'],
        pageSize: 20,
        typeAhead: false,
        editable: true,
        allowBlank: false,
        url: Inventario.config['connector_url'],
        baseParams: {
            action: 'mgr/group/getlist',
            combo: true,
        },
        tpl: new Ext.XTemplate(
            '\
            <tpl for=".">\
                <div class="x-combo-list-item">\
                    <span>\
                        <small>({id})</small>\
                        <b>{name}</b>\
                    </span>\
                </div>\
            </tpl>',
            {compiled: true}
        ),
    });
    Inventario.combo.Groups.superclass.constructor.call(this, config);
};
Ext.extend(Inventario.combo.Groups, Inventario.combo.ComboBoxDefault);
Ext.reg('inventario-combo-groups', Inventario.combo.Groups);

Inventario.combo.UGroups = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        name: 'user_group',
        fieldLabel: config.name || 'user_group',
        hiddenName: config.name || 'user_group',
        displayField: 'name',
        valueField: 'id',
        anchor: '99%',
        fields: ['id', 'name'],
        pageSize: 20,
        typeAhead: false,
        editable: true,
        allowBlank: false,
        url: Inventario.config['connector_url'],
        baseParams: {
            action: 'mgr/ugroup/getlist',
            combo: true,
        },
        tpl: new Ext.XTemplate(
            '\
            <tpl for=".">\
                <div class="x-combo-list-item">\
                    <span>\
                        <small>({id})</small>\
                        <b>{name}</b>\
                    </span>\
                </div>\
            </tpl>',
            {compiled: true}
        ),
    });
    Inventario.combo.UGroups.superclass.constructor.call(this, config);
};
Ext.extend(Inventario.combo.UGroups, Inventario.combo.ComboBoxDefault);
Ext.reg('inventario-combo-ugroups', Inventario.combo.UGroups);