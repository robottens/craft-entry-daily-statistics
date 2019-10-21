<?php
namespace robottens\dailystatistics\controllers;

use Craft;
use craft\db\Query;
use craft\helpers\UrlHelper;
use craft\web\Controller;

use yii\web\ForbiddenHttpException;
use yii\web\Response;

use robottens\DailyStatistics;

class DashboardController extends Controller
{

    public function actionIndex()
    {
        $this->renderTemplate('dailystatistics/index');
    }

}
