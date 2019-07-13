<?php

namespace robottens\dailystatistics\records;

use craft\db\ActiveRecord;

/**
 * EntryCountRecord
 *
 * @property int         $id                         ID
 * @property int         $entryId                    Entry ID
 * @property int         $count                      Count
 */
class DailyStatisticsRecord extends ActiveRecord
{

    public $month;

    public $total_count;

    // Public Static Methods
    // =========================================================================

     /**
     * @inheritdoc
     *
     * @return string the table name
     */
    public static function tableName(): string
    {
        return '{{%entrycount}}';
    }
}
