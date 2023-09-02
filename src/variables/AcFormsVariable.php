<?php

namespace sparkalow\activecampaignforms\variables;

use Craft;

class AcFormsVariable
{
    /**
     * Output the markup for an ActiveCampaign "simple" form embed
     * @param int $formId ActiveCampaign Form ID
     * @return void
     * @see https://help.activecampaign.com/hc/en-us/articles/115001257184-How-to-publish-a-form-to-your-website#how-to-publish-a-form-to-your-website-0-0
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \yii\base\Exception
     */
    public function renderForm(string $formId )
    {
        echo Craft::$app->view->renderTemplate('ac-forms/form-embed.twig', [
            'formId' => $formId
        ]);
    }
}