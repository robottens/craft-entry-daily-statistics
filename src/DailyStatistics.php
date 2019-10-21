<?php
namespace robottens\dailystatistics;

use Craft;
use craft\web\UrlManager;
use craft\base\Plugin;
use craft\services\Fields;
use craft\events\RegisterComponentTypesEvent;
use craft\web\twig\variables\CraftVariable;
use robottens\dailystatistics\fields\DailyStatisticsField;
use robottens\dailystatistics\services\DailyStatisticsService;
use robottens\dailystatistics\variables\DailyStatisticsVariable;
use yii\base\Event;
use craft\events\RegisterUrlRulesEvent;

class DailyStatistics extends Plugin
{

    public static $plugin;

    public $hasCpSection = true;

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

        // Register our CP routes
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['dailystatistics'] = 'dailystatistics/dashboard/index';
            }
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
