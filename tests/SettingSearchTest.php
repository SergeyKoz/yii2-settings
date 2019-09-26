<?php
/**
 * Created by PhpStorm.
 * User: zjw
 * Date: 2017/8/8
 * Time: 上午11:29
 */

namespace ssoft\settings\tests;

use ssoft\settings\models\SettingSearch;

class SettingSearchTest extends TestCase
{
    public function testSearch()
    {
        $this->model->value = "i am value";
        $this->model->section = "testUpdate";
        $this->model->type = 'string';
        $this->model->key = "testUpdate";
        $this->model->active = "1";
        $this->model->save();
        $params = ['SettingSearch' => ['active' => 1]];
        $model = new SettingSearch();
        $res = $model->search($params);
        $this->assertTrue($res->count == 1);
        $res1 = $model->search(['SettingSearch'=>[]]);
        $this->assertTrue($res1->count == 1);
    }
}
