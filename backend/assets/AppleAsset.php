<?php

namespace backend\assets;


use yii\web\AssetBundle;

/**
 * Class AppleAsset
 */
class AppleAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/src';

    public $css = [
        'css\antd.css',
    ];

    public $js = [
        'js\apples-main.js',
    ];
}