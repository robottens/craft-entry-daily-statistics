<?php
namespace robottens\dailystatistics\models;

use craft\base\Model;

/**
 * EntryCountModel
 */
class DailyStatisticsModel extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var \DateTime|null Date
     */
    public $date;

    /**
     * @var int|null Entry ID
     */
    public $entryId;

    /**
     * @var int Count
     */
    public $count = 0;

    /**
     * @var int Time On Page
     */
    public $timeOnPage = 0;

    // Public Methods
    // =========================================================================

    /**
     * Define what is returned when model is converted to string
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->count;
    }
}
