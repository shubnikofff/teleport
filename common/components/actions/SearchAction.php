<?php
/**
 * Created by PhpStorm.
 * User: bill
 * Date: 13.10.15
 * Time: 14:43
 */

namespace common\components\actions;

use yii\base\InvalidConfigException;
use yii\helpers\Url;
use yii\base\Model;

/**
 * Class SearchAction
 * @package common\components\actions
 *
 * @property Model $_model
 */
class SearchAction extends BaseAction
{
    /**
     * @var string
     */
    public $scenario;
    /**
     * @var string
     */
    public $view = 'index';
    /**
     * @var string
     */
    public $resultsView;

    public function init()
    {
        if (!is_subclass_of($this->modelClass, Model::className())) {
            throw new InvalidConfigException("Provided model class '{$this->modelClass}' must extend Model class");
        }
    }

    public function run()
    {
        return parent::run();
    }

    protected function setModel($id)
    {
        $this->_model = new $this->modelClass();

        if (isset($this->scenario)) {
            $this->_model->scenario = $this->scenario;
        }
    }

    protected function processRequest()
    {
        $this->_model->load(\Yii::$app->request->get());

        $viewParams = ['searchModel' => $this->_model];

        if (\Yii::$app->request->isPjax && isset($this->resultsView)) {
            return $this->controller->renderAjax($this->resultsView, $viewParams);
        }

        Url::remember();

        return $this->controller->render($this->view, $viewParams);
    }
}