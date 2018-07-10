<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 */

namespace apol\yii2\ckeditordual;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * @author Semenov Alexander <semenov@skeeks.com>
 */
class CKEditorWidget extends InputWidget
{
    /**
     * @var string
     */
    public $preset = CKEditorPresets::FULL;

    public $totalNum = 1;

    /**
     * @var array the options for the CKEditor 4 JS plugin.
     * Please refer to the CKEditor 4 plugin Web page for possible options.
     * @see http://docs.ckeditor.com/#!/guide/dev_installation
     */
    public $clientOptions = [];


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->_initOptions();
    }

    /**
     * Initializes the widget options.
     * This method sets the default values for various options.
     */
    protected function _initOptions()
    {
        $options = [];

        if ($this->preset) {
            $options = CKEditorPresets::getPresets($this->preset);
        }

        $this->clientOptions = ArrayHelper::merge((array)$options, $this->clientOptions);
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->hasModel()) {
            echo Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textarea($this->name, $this->value, $this->options);
        }
        $this->registerAssets();
        $this->_registerPlugin();
    }

    /**
     * @return $this
     */
    public function registerAssets()
    {
        $view = $this->getView();
        CKEditorWidgetAsset::register($view);

        return $this;
    }

    /**
     * Registers CKEditor plugin
     */
    protected function _registerPlugin()
    {
        $view = $this->getView();
        $id = $this->options['id'];


//var_dump($this->clientOptions);
//exit();
        if ($id == "htmltext-content2") {
            $this->totalNum = 2;
            $this->clientOptions['startupMode'] = 'source';
        } else {
            $this->totalNum = 1;
        }
        $options = $this->clientOptions !== false && !empty($this->clientOptions)
            ? Json::encode($this->clientOptions)
            : '{}';

        $js[] = "var editor{$this->totalNum} = CKEDITOR.replace('$id', $options);";
        $js[] = "skeeks.ckEditorWidget.registerOnChangeHandler('$id');";

        if (isset($this->clientOptions['filebrowserUploadUrl'])) {
            $js[] = "skeeks.ckEditorWidget.registerCsrfImageUploadHandler();";
        }

        if ($id == "htmltext-content2") {
//            var_dump(123);
//            exit();
            $js[] = "editor1.on( 'key', function( evt ) {
        changeContent (evt, editor2);
    });
    editor2.on( 'key', function( evt ) {
        changeContent (evt, editor1);
    });

    
    function changeContent (evt, recipient) {
        swBlock = true;
        var value = evt.editor.getData();
        // console.log( value );        
        recipient.setData(value);
    }";
        }
        $this->totalNum++;
        $view->registerJs(implode("\n", $js));
    }
}