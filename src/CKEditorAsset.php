<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 */

namespace apol88\yii2\ckeditordual;

use yii\web\AssetBundle;

/**
 * @author Semenov Alexander <semenov@skeeks.com>
 */
class CKEditorAsset extends AssetBundle
{
    public $sourcePath = '@apol/yii2/ckeditorhtml/assets';

    public $js = [
        'ckeditor/ckeditor.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
    ];
} 