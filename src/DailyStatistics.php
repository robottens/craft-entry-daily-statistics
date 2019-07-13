<?php
namespace robottens\dailystatistics;

use Craft;
use craft\base\Plugin;
use craft\services\Fields;
use craft\events\RegisterComponentTypesEvent;
use craft\web\twig\variables\CraftVariable;
use robottens\dailystatistics\fields\DailyStatisticsField;
use robottens\dailystatistics\services\DailyStatisticsService;
use robottens\dailystatistics\variables\DailyStatisticsVariable;
use yii\base\Event;

class DailyStatistics extends Plugin
{

    public static $plugin;

    public function init()
    {

        parent::init();
        self::$plugin = $this;

        // Register services as components
        $this->setComponents([
            'dailyStatistics' => DailyStatisticsService::class,
        ]);

        // Field type
        Event::on(
			Fields::class,
			Fields::EVENT_REGISTER_FIELD_TYPES,
			[$this, 'onRegisterFieldTypes']
		);

        // Register variable
        Event::on(CraftVariable::class, CraftVariable::EVENT_INIT, function(Event $event) {
            /** @var CraftVariable $variable */
            $variable = $event->sender;
            $variable->set('entryCount', DailyStatisticsVariable::class);
        });
    }

    public function onRegisterFieldTypes (RegisterComponentTypesEvent $event)
	{
		$event->types[] = DailyStatisticsField::class;
	}
}
