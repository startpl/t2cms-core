# T2 CMS
======
Multidomain & Multilanguage CMS based on Yii2

## Installation
------------

You can install T2CMS as a template, [ready-made Yii2 application](https://github.com/startpl/t2cms)

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist startpl/t2cms "*"
```

Then add to the console application config:
```php
'modules' => [
    //..
    'user' => [
        'class' => 't2cms\user\console\Module',
    ], 
    't2cms' => [
        'class' => 't2cms\base\console\Module',
    ], 
    //..
]
```

Next, run the console command
```
yii t2cms/init
```

## Preparing Application
------------

Add the application backend to the config:

##### Modules
```php
'modules' => [
    //...
    'manager' => [
        'class' => 't2cms\sitemanager\Module',
    ],
    'blog' => [
        'class' => 'startpl\t2cmsblog\backend\Module',
    ],
    'menu' => [
        'class' => 't2cms\menu\Module',
    ],
    'design' => [
        'class' => 't2cms\design\Module',
    ],
    'user' => [
        'class' => 't2cms\user\backend\Module',
    ],
    'module' => [
        'class' => 't2cms\module\Module',
    ],
    //...
],

```
##### Components
```php
'components' => [
    'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'suffix' => '/',
        'rules' => [
            'manager' => 'manager/default/index',
            [
                'class' => 'yii\web\GroupUrlRule',
                'prefix' => 'manager',
                'rules' => [
                    '/<controller:domains|languages>/<action:\w+>' => 'manager/<controller>/<action>',
                    '/<controller:domains|languages>' => 'manager/<controller>/index',
                    '/<action:\w+>' => 'manager/default/<action>',
                ],
            ],

            'blog' => 'blog/default/index',
            [
                'class' => 'yii\web\GroupUrlRule',
                'prefix' => 'blog',
                'rules' => [
                    '/pages' => 'blog/pages/index',
                    '/pages/<action:\w+>' => 'blog/pages/<action>',
                    '/<action:\w+>' => 'blog/<action>',
                ],
            ],


            'menu' => 'menu/default/index',
            [
                'class' => 'yii\web\GroupUrlRule',
                'prefix' => 'menu',
                'rules' => [
                    '/<controller:item>/<action:\w+>' => 'menu/item/<action>',
                    '/<controller:item>' => 'menu/item/index',
                    '/<action:\w+>' => 'menu/default/<action>',
                ],
            ],

            'module' => 'module/default/index',
            'module/<action:install|uninstall|update|activate|deactivate|view>' => 'module/default/<action>',

            'design' => 'design/default/index',
            'design/<action:[\w\-]+>' => 'design/default/<action>',

            'user' => 'user/default/index',
            [
                'class' => 'yii\web\GroupUrlRule',
                'prefix' => 'user',
                'rules' => [
                    '/<controller:permissions|roles>/<action:\w+>' => 'user/<controller>/<action>',
                    '/<controller:permissions|roles>' => 'user/<controller>/index',
                    '/<action:\w+>' => 'user/default/<action>',
                ],
            ],

            '<action:[\w\-]+>' => 'site/<action>'
        ],
    ],
    'urlManagerFrontend' => [
        'class' => 'yii\web\UrlManager',
        'baseUrl' => '',
        'enablePrettyUrl' => true,
        'enableStrictParsing' => true,
        'showScriptName' => false,
        'rules' => [
            [
                'class' => 'startpl\t2cmsblog\components\CategoryUrlRule',
                //'prefix' => 'blog'
            ],
            [
                'class' => 'startpl\t2cmsblog\components\PageUrlRule',
                //'prefix' => 'blog'
            ],
        ],
    ],
    'settings' => [
        'class' => 't2cms\sitemanager\components\Settings',
    ],
    'domains' => [
        'class' => 't2cms\sitemanager\components\Domains',
    ],
    'languages' => [
        'class' => 't2cms\sitemanager\components\Languages',
    ],
]
```
## Usage
----

Go to backend application ( /admin ).