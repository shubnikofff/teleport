<?php
/**
 * Copyright (c) 2016. OSKR JSC "NIAEP"
 */

namespace frontend\assets;

use common\assets\DomAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;


/**
 * @author Shubnikov Alexey <a.shubnikov@niaep.ru>
 *
 * BookingFormAsset
 */
class BookingFormAsset extends AssetBundle
{
    public $sourcePath = '@app/assets';

    public $js = [
        'js/bookingForm.js',
    ];

    public $css = [
        'css/bookingForm.css'
    ];

    public $depends = [
        DomAsset::class,
        JqueryAsset::class
    ];
}