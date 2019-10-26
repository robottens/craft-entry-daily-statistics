<?php
namespace robottens\dailystatistics\controllers;

use Craft;
use craft\db\Query;
use craft\helpers\UrlHelper;
use craft\web\Controller;

use robottens\dailystatistics\helpers\MultiSite as MultiSiteHelper;
use robottens\dailystatistics\helpers\Date as DateHelper;

use yii\web\ForbiddenHttpException;
use yii\web\Response;

use craft\base\Component;
use craft\elements\db\EntryQuery;
use craft\elements\Entry;
use robottens\dailystatistics\models\DailyStatisticsModel;
use robottens\dailystatistics\records\DailyStatisticsRecord;

use robottens\DailyStatistics;

class DashboardController extends Controller {

    public function actionIndex($siteHandle = null, $date = null) {

        // Set some default variables
        $variables = [];
        $variables['controllerHandle'] = '';

        // Set sites
        $siteId = MultiSiteHelper::getSiteIdFromHandle($siteHandle);
        MultiSiteHelper::setMultiSiteVariables($siteHandle, $siteId, $variables);

        // Set month
        $month = DateHelper::getDateFromHandle($date);
        $variables['selectedMonth'] = $month;
        DateHelper::setDateVariables($month, $variables);

        // Get the pageviews per day for current site
        $records = DailyStatisticsRecord::find()
            ->select([
                'date',
                'DATE_FORMAT(date, "%m-%Y") AS month',
                'SUM(count) AS total_count',
                'SUM(uniqueCount) AS total_unique_count',
                'SUM(qualityCount) AS total_quality_count',
                'SUM(qualityUniqueCount) AS total_quality_unique_count'
            ])
            ->join('INNER JOIN', 'content', 'content.elementId = entrycount.entryId')
            ->where([
                'content.siteId' => $siteId,
                'DATE_FORMAT(date, "%Y-%m")' => $month
            ])
            ->groupBy(['date'])
            ->orderBy('date DESC')
            ->all();

        $variables['records'] = $records;

        // Render the page
        $this->renderTemplate('dailystatistics/index', $variables);
    }

}
