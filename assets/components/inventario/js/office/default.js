Ext.onReady(function () {
    Inventario.config.connector_url = OfficeConfig.actionUrl;

    var grid = new Inventario.panel.Home();
    grid.render('office-inventario-wrapper');

    var preloader = document.getElementById('office-preloader');
    if (preloader) {
        preloader.parentNode.removeChild(preloader);
    }
});