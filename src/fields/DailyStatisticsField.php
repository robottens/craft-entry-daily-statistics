<?php

namespace robottens\dailystatistics\fields;

use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use craft\elements\Category;
use craft\elements\Entry;
use craft\helpers\Json;
use craft\models\Section;
use yii\base\InvalidConfigException;
use yii\db\Schema;
use robottens\dailystatistics\services\DailyStatisticsService;

class DailyStatisticsField extends Field implements PreviewableFieldInterface
{

	// Props
	// =========================================================================

	// Static
	// -------------------------------------------------------------------------

	public static $defaultFieldSettings = [
	];

	// Public Functions
	// =========================================================================

	// Static
	// -------------------------------------------------------------------------

	public static function displayName (): string
	{
		return 'Daily Statistics';
	}

	public static function hasContentColumn (): bool
	{
		return false;
	}

	// Instance
	// -------------------------------------------------------------------------

	/**
	 * @param SeoData               $value
	 * @param ElementInterface|null $element
	 *
	 * @return string
	 * @throws InvalidConfigException
	 * @throws \Twig_Error_Loader
	 * @throws \yii\base\Exception
	 */
	public function getInputHtml ($value, ElementInterface $element = null): string
	{
		if (!$element) return '';

		$service = new DailyStatisticsService;
		$dayRangeCount = $service->getDayRangeCount($element->id, date('Y-m-d', strtotime('-31 days') ), date('Y-m-d') );

		$service = new DailyStatisticsService;
		$monthlyCount = $service->getMonthlyCount($element->id);

		$craft = \Craft::$app;

		return $craft->view->renderTemplate(
			'dailystatistics/fieldtype',
			[
				'id' => $this->id,
				'name' => $this->handle,
				'dayRangeCount' => $dayRangeCount,
				'monthlyCount' => $monthlyCount
			]
		);
	}

}
