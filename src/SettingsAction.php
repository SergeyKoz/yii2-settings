<?php
namespace ssoft\settings;

use Yii;
use yii\base\Action;

class SettingsAction extends Action
{
    /**
     * @var string class name of the model which will be used to validate the attributes.
     * The class should have a scenario matching the `scenario` variable.
     * The model class must implement [[Model]].
     * This property must be set.
     */
    public $modelClass;

    /**
     * @var string The scenario this model should use to make validation
     */
    public $scenario;

    /**
     * @var string the name of the view to generate the form. Defaults to 'settings'.
     */
    public $viewName = 'settings';

    /**
     * @var string name on section. Default is ModelClass formname
     */
    public $section = null;

    /**
     * Render the settings form.
     */
    public function run()
    {
        /* @var $model \yii\db\ActiveRecord */
        $model = new $this->modelClass();
        $section = ($this->section !== null) ? $this->section : $model->formName();
        if ($this->scenario) {
            $model->setScenario($this->scenario);
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            foreach ($model->toArray() as $key => $value) {
                Yii::$app->settings->set($key, $value, $section);
            }
            Yii::$app->getSession()->addFlash('success',
                Module::t('settings', 'Successfully saved settings on {section}',
                    ['section' => $model->formName()]
                )
            );
        }
        foreach ($model->attributes() as $key) {
            $model->{$key} = Yii::$app->settings->get($key, $section);
        }
        return $this->controller->render($this->viewName, ['model' => $model]);
    }
}
