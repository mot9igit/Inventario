<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    $dev = MODX_BASE_PATH . 'Extras/Inventario/';
    /** @var xPDOCacheManager $cache */
    $cache = $modx->getCacheManager();
    if (file_exists($dev) && $cache) {
        if (!is_link($dev . 'assets/components/inventario')) {
            $cache->deleteTree(
                $dev . 'assets/components/inventario/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_ASSETS_PATH . 'components/inventario/', $dev . 'assets/components/inventario');
        }
        if (!is_link($dev . 'core/components/inventario')) {
            $cache->deleteTree(
                $dev . 'core/components/inventario/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_CORE_PATH . 'components/inventario/', $dev . 'core/components/inventario');
        }
    }
}

return true;