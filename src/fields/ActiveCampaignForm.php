<?php

namespace sparkalow\activecampaignforms\fields;

use Craft;
use craft\base\ElementInterface;
use craft\fields\Dropdown;
use sparkalow\activecampaignforms\Plugin;

/**
 * Active Campaign Form field type
 */
class ActiveCampaignForm extends Dropdown
{
    public static function displayName(): string
    {
        return Craft::t('activecampaign-forms', 'ActiveCampaign Form');
    }

    /**
     * Get the input html.  Will return error states html if the field is not working properly
     * @param mixed $value
     * @param ElementInterface|null $element
     * @return string
     */
    public function getInputHtml(mixed $value, ?ElementInterface $element = null): string
    {
        $settings = Plugin::$plugin->getSettings();

        //  missing credentials
        if (!$settings->apiKey || !$settings->account){
            return sprintf('You must setup your ActiveCampaign API key in <a href="%s">plugin settings</a>.', Plugin::getInstance()->getSettingsUrl());
        }
        // a network error or bad credentials
        if (empty($this->options)){
            return  sprintf('error - No forms found. Are the correct ActiveCampaign API credentials used in <a href="%s">settings</a>?',Plugin::getInstance()->getSettingsUrl());
        }
        return parent::getInputHtml($value, $element);
    }

    /**
     * We return null here to prevent configuring options (select tag options) in the control panel
     * @return string|null
     */
    public function getSettingsHtml(): ?string
    {
        return null;
    }


    /**
     * Return the available options
     * @return array
     */
    protected function options(): array
    {
        try {
            $forms = Plugin::getInstance()->activeCampaignApI->get('forms');
            $options = [];
            foreach ($forms->forms as $key => $formObj) {
                $options[] = [
                    'label' => $formObj->name,
                    'value' => $formObj->id
                ];
            }
            $this->options = $options;

        } catch (\Exception $e) {
            Craft::error($e->getMessage(), __METHOD__);
        }


        return $this->options ?? [];
    }

    /**
     * Get available ActiveCampaign forms.
     * This should only be called when rendering the form in the admin to save  API rate limits
     * @param string $value
     * @return array
     */
    protected function getFormOptions(string $value = null): array
    {
        $forms = Plugin::getInstance()->activeCampaignApI->get('forms');
        $options = [];

        if (!$value) {
            $options[] = [
                'label' => 'Choose a form',
                'value' => '',
                'disabled' => true,
            ];
        }

        foreach ($forms->forms as $key => $formObj) {
            $options[] = [
                'label' => $formObj->name,
                'value' => $formObj->id,
                'selected' => $value === $formObj->id
            ];
        }

        return $options;
    }
}
