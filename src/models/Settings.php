<?php

namespace sparkalow\activecampaignforms\models;

use Craft;
use craft\base\Model;

/**
 * Activecampaign Forms settings
 */
class Settings extends Model
{
    public $account ='';
    public $apiKey ='';


    public function defineRules(): array
    {
        return [
            [['account','apiKey'],'required']
        ];
    }
}
