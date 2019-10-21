<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace robottens\dailystatistics\variables;

use craft\elements\db\EntryQuery;
use robottens\dailystatistics\DailyStatistics;
use robottens\dailystatistics\models\DailyStatisticsModel;

/**
 * Entry Count Variable
 */
class DailyStatisticsVariable
{
    /**
     * Returns count
     *
     * @param int $entryId
     *
     * @return EntryCountModel
     */
    public function getCount($entryId, $date): DailyStatisticsModel
    {
        return DailyStatistics::$plugin->dailyStatistics->getCount($entryId, $date);
    }

    /**
     * Increment count
     *
     * @param int $entryId
     */
    public function increment($entryId, $date)
    {
        DailyStatistics::$plugin->dailyStatistics->increment($entryId, $date);
    }
}
