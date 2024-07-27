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
    public $apiCacheDuration = 0;


    public function defineRules(): array
    {
        return [
            [['account','apiKey'],'required'],
            [['apiCacheDuration'],'numeric']
        ];
    }
}
