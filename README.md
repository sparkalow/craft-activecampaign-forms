# ActiveCampaign Forms

Easily add [ActiveCampaign](https://www.activecampaign.com/) forms to entries with a custom field type. Then render the form with a simple twig method. 
Simplify managing embed snippets for content authors.


> **Note:** This plugin is not affiliated with ActiveCampaign, Inc.


## Requirements

This plugin requires Craft CMS 4.4.0 or later, and PHP 8.0.2 or later. 

An ActiveCampaign account is also necessary.

## Installation

You can install this plugin from the Plugin Store or with Composer.

#### From the Plugin Store

Go to the Plugin Store in your project’s Control Panel and search for “ActiveCampaign Forms”. Then press “Install”.

#### With Composer

Open your terminal and run the following commands:

```bash
# go to the project directory
cd /path/to/my-project.test

# tell Composer to load the plugin
composer require sparkalow/craft-activecampaign-forms

# tell Craft to install the plugin
./craft plugin/install activecampaign-forms
```


## Configuration

You will need your ActiveCampaign account and API key. 

See the [official docs](https://help.activecampaign.com/hc/en-us/articles/207317590-Getting-started-with-the-API) for how to find them in ActiveCampaign.


Configuration can be managed  from **Settings** → **ActiveCampaign Forms**. 

You can also create an `activecampaign-forms.php` config file in your `/config` directory with the following options.

```php
<?php

return [
    'account' => 'your_account_url',
    'apiKey' => 'your_api_key',
];
```

## Usage

This plugin provides a new field type for selecting forms created within ActiveCampaign. Create a new ActiveCampaign Form field and add it to entry types. 

Render a form from the field with:
```twig
 {{ craft.acforms.renderForm(entry.yourFieldHandle) | raw }}
```

This will render the form using ActiveCampaign's "Simple Embed" markup.
