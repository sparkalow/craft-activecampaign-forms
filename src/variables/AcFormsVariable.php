<?php

namespace sparkalow\activecampaignforms\variables;

use Craft;

class AcFormsVariable
{
    /**
     * Output the markup for an ActiveCampaign form embed
     * @param int $formId ActiveCampaign Form ID
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \yii\base\Exception
     */
    public function renderForm(int $formId)
    {
        echo Craft::$app->view->renderTemplate('ac-forms/form-embed.twig', [
            'formId' => $formId
        ]);
    }
}