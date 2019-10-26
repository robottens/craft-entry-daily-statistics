<?php
namespace robottens\dailystatistics\helpers;

use Craft;

use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * @author    nystudio107
 * @package   Retour
 * @since     3.0.0
 */
class Date
{
    public static function getDateFromHandle($date)
    {

        if ($date === null) {
            return date('Y-m');
        }

        $dates = explode('-', $date);

        if (count($dates) <> 2) {
            return date('Y-m');
        }

        if (!checkdate($dates[1], 1, $dates[0]) ) {
            return date('Y-m');
        }

        return $date;
    }

    public static function setDateVariables($month, array &$variables)
    {
        $variables['dates'] = [];

        $dt = new \DateTime('first day of this month');
        for ($i = 1; $i <= 10; $i++) {
            $variables['dates'][] = $dt->format('Y-m');
            $dt->modify("-1 month");
        }
    }
}
