<?php

namespace robottens\dailystatistics\services;

use Craft;
use craft\base\Component;
use craft\elements\db\EntryQuery;
use craft\elements\Entry;
use robottens\dailystatistics\DailyStatistics;
use robottens\dailystatistics\models\DailyStatisticsModel;
use robottens\dailystatistics\records\DailyStatisticsRecord;
use yii\base\Event;

/**
 * EntryCountService
 *
 * @property EntryQuery $entries
 */
class DailyStatisticsService extends Component
{

    // Public Methods
    // =========================================================================

    /**
     * Returns count
     *
     * @param int $entryId, $date
     *
     * @return DailyStatisticsModel
     */
    public function getDateCount($entryId, $date): DailyStatisticsModel
    {
        // create new model
        $dailyStatisticsModel = new DailyStatisticsModel();

        // get record from DB
        $dailyStatisticsRecord = DailyStatisticsRecord::find()
            ->where(['entryId' => $entryId, 'date' => $date])
            ->one();

        if ($dailyStatisticsRecord) {
            // populate model from record
            $dailyStatisticsModel->setAttributes($dailyStatisticsRecord->getAttributes(), false);
        }

        return $dailyStatisticsModel;
    }

    public function getDayRangeCount($entryId, $startDate, $endDate) {

        $format = 'Y-m-d';

        if (\DateTime::createFromFormat($format, $startDate)->format($format) !== $startDate) {
            return false;
        }

        if (\DateTime::createFromFormat($format, $endDate)->format($format) !== $endDate) {
            return false;
        }

        $records = DailyStatisticsRecord::find()
            ->where(['entryId' => $entryId])
            ->andWhere(['between', 'date', $startDate, $endDate])
            ->orderBy('date DESC')
            ->all();

        return $records;
    }

    public function getMonthlyCount($entryId) {

        $records = DailyStatisticsRecord::find()
            ->select([
                'DATE_FORMAT(date, "%m-%Y") AS month',
                'SUM(count) AS total_count',
                'SUM(uniqueCount) AS total_unique_count',
                'SUM(qualityCount) AS total_quality_count',
                'SUM(qualityUniqueCount) AS total_quality_unique_count'
            ])
            ->where(['entryId' => $entryId])
            ->groupBy(['month'])
            ->orderBy('month DESC')
            ->all();

        // die(var_dump($records->createCommand()->getRawSql()) );

        return $records;
    }

    /**
     * Increment count
     *
     * @param int $entryId, $date
     */
    public function increment($entryId, $date)
    {

        // get record from DB
        $dailyStatisticsRecord = DailyStatisticsRecord::find()
            ->where(['entryId' => $entryId, 'date' => $date])
            ->one();

        // if exists then increment count
        if ($dailyStatisticsRecord) {
            Craft::$app->db->createCommand()
                ->update('entrycount', [
                    'count' => $dailyStatisticsRecord->getAttribute('count') + 1
                ], 'date = :date AND entryId = :entryId', [':date' => $date, ':entryId' => $entryId]
                , false)
                ->execute();
        }

        // otherwise create a new record
        else {
            Craft::$app->db->createCommand()
                ->insert('entrycount', [
                    'date' => $date,
                    'entryId' => $entryId,
                    'count' => 1,
                    'timeOnSite' => 0
                ], false)->execute();
        }
    }
}
