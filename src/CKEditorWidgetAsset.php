<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 */

namespace apol\yii2\ckeditordual;

/**
 * @author Semenov Alexander <semenov@skeeks.com>
 */
class CKEditorWidgetAsset extends CKEditorAsset
{
    public $depends = [
        'apol\yii2\ckeditorhtml\CKEditorAsset',
    ];

    public $js = [
        'js/skeeks-ckeditor.widget.js',
    ];
} 