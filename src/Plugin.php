<?php

namespace sparkalow\activecampaignforms;

use Craft;
use craft\base\Model;
use craft\base\Plugin as BasePlugin;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterTemplateRootsEvent;
use craft\helpers\UrlHelper;
use craft\services\Fields;
use craft\web\twig\variables\CraftVariable;
use craft\web\View;
use sparkalow\activecampaignforms\fields\ActiveCampaignForm;
use sparkalow\activecampaignforms\models\Settings;
use sparkalow\activecampaignforms\services\ActiveCampaignApI;
use sparkalow\activecampaignforms\variables\AcFormsVariable;
use yii\base\Event;

/**
 * Activecampaign Forms plugin
 *
 * @method static Plugin getInstance()
 * @method Settings getSettings()
 * @author Brian Matthews <support@slapthink.net>
 * @copyright Brian Matthews
 * @license MIT
 * @property-read ActiveCampaignApI $activeCampaignApI
 */
class Plugin extends BasePlugin
{
    public static Plugin $plugin;
    public string $schemaVersion = '1.0.0';
    public bool $hasCpSettings = true;

    public static function config(): array
    {
        return [
            'components' => ['activeCampaignApI' => ActiveCampaignApI::class],
        ];
    }

    /**
     * @return void
     */
    public function init(): void
    {
        parent::init();
        self::$plugin = $this;

        // Defer most setup tasks until Craft is fully initialized
        Craft::$app->onInit(function () {
            $this->attachEventHandlers();
        });
    }

    /**
     * Create/get settings model
     * @return Model|null
     * @throws \yii\base\InvalidConfigException
     */
    protected function createSettingsModel(): ?Model
    {
        return Craft::createObject(Settings::class);
    }

    /**
     * Render settings view
     * @return string|null
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \yii\base\Exception
     */
    protected function settingsHtml(): ?string
    {
        return Craft::$app->view->renderTemplate('activecampaign-forms/_settings.twig', [
            'plugin' => $this,
            'settings' => $this->getSettings(),
        ]);
    }

    /**
     * Setup event handlers
     * @return void
     * @link  https://craftcms.com/docs/4.x/extend/events.html
     */
    private function attachEventHandlers(): void
    {
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                $variable = $event->sender;
                $variable->set('acforms', AcFormsVariable::class);
            }
        );


        Event::on(Fields::class, Fields::EVENT_REGISTER_FIELD_TYPES, function (RegisterComponentTypesEvent $event) {
            $event->types[] = ActiveCampaignForm::class;
        });

        Event::on(
            View::class,
            View::EVENT_REGISTER_SITE_TEMPLATE_ROOTS,
            function(RegisterTemplateRootsEvent $event) {
                $event->roots['ac-forms'] = __DIR__ . '/templates/ac-forms';
            }
        );
    }

    /**
     * Get controlpanel settings url
     * @return string
     */
    public function getSettingsUrl(): string
    {
        return UrlHelper::cpUrl('settings/plugins/activecampaign-forms');
    }
}
