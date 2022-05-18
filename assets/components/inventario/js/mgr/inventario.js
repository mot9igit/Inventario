var Inventario = function (config) {
    config = config || {};
    Inventario.superclass.constructor.call(this, config);
};
Ext.extend(Inventario, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('inventario', Inventario);

Inventario = new Inventario();