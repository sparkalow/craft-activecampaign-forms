# ActiveCampaign Forms

A new field type to easily add [ActiveCampaign](https://www.activecampaign.com/) forms to Craft CMS entries. Render the form in your templates with a simple twig method. 
Simplify managing embed snippets for content authors.


> **Note:** This plugin is not affiliated with ActiveCampaign, Inc. It is provided by a 3rd party.


## Requirements

This plugin requires Craft CMS 4.4.0 or later, and PHP 8.0.2 or later. 

An ActiveCampaign account is also necessary.

## Installation

You can install this plugin via the Plugin Store or using Composer.

#### From the Plugin Store

Go to the Plugin Store in your project’s Control Panel or the web version and search for “ActiveCampaign Forms”. Then click “Install”.

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


## Setup

Once the plugin is installed:


1. Go to **Settings** → **ActiveCampaign Forms**.
2. Enter your ActiveCampaign **Account URL**.
3. Enter your **API Key**.
4. Click **Save**.

>  See the [official docs](https://help.activecampaign.com/hc/en-us/articles/207317590-Getting-started-with-the-API) for info on how to get your key.

Alternatively, you can also create an `activecampaign-forms.php` config file in your `/config` directory with the following options.

```php
<?php

return [
    'account' => 'your_account_url',
    'apiKey' => 'your_api_key',
];
```

>  See [Environmental Configuration](https://craftcms.com/docs/4.x/config/#environmental-configuration) in the Craft documentation to learn more.

## Usage

This plugin provides a new field type for selecting forms created on the ActiveCampaign platform. Create a new ActiveCampaign form field and add it to your entry types. 

Render a form field with:
```twig
 {{ craft.acforms.renderForm(entry.yourFieldHandle) | raw }}
```

This will render the form using ActiveCampaign's "Simple Embed" markup. This is essentially the same as copy/pasting the embed snippet.
