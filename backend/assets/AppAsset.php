<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/site.css',
        'dist/css/style.css',
    ];
    public $js = [
        'asset_files/libs/jquery/dist/jquery.min.js',
        'asset_files/libs/popper.js/dist/umd/popper.min.js',
        'asset_files/libs/bootstrap/dist/js/bootstrap.min.js',
        'dist/js/app.min.js',
        'dist/js/app.init.js',
        'asset_files/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js',
        'dist/js/sidebarmenu.js',
        'dist/js/custom.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
