<?php
return [
    [
        'name' => 'disconnected',
        'required' => true,
        'autoload' => true,
        'status'   => t2cms\sitemanager\models\Setting::STATUS['COMMON'],
        'defaultValue' => [
            'value' => 0,
            'domain_id' => null,
            'language_id' => null
        ],
    ],
    [
        'name' => 'site_name',
        'required' => true,
        'autoload' => true,
        'status'   => t2cms\sitemanager\models\Setting::STATUS['COMMON'],
        'defaultValue' => [
            'value' => 'New site',
            'domain_id' => null,
            'language_id' => null
        ],
    ],
    [
        'name' => 'home_page_type',
        'required' => true,
        'autoload' => false,
        'status' => t2cms\sitemanager\models\Setting::STATUS['GENERAL'],
        'defaultValue' => [
            'value' => 0,
            'domain_id' => null,
            'language_id' => null
        ],
    ],
    [
        'name' => 'home_page',
        'required' => true,
        'autoload' => false,
        'status' => t2cms\sitemanager\models\Setting::STATUS['GENERAL'],
        'defaultValue' => [
            'value' => 1,
            'domain_id' => null,
            'language_id' => null
        ],
    ],
    [
        'name' => 'design',
        'required' => true,
        'autoload' => true,
        'status' => t2cms\sitemanager\models\Setting::STATUS['SYSTEM'],
        'defaultValue' => [
            'value' => 'first-theme',
            'domain_id' => null,
            'language_id' => null
        ],
    ],
    [
        'name' => 'robots',
        'required' => false,
        'autoload' => false,
        'status' => t2cms\sitemanager\models\Setting::STATUS['COMMON'],
        'defaultValue' => [
            'value' => '',
            'domain_id' => null,
            'language_id' => null
        ],
    ],
    [
        'name' => 'title_contain_sitename',
        'required' => false,
        'autoload' => true,
        'status' => t2cms\sitemanager\models\Setting::STATUS['COMMON'],
        'defaultValue' => [
            'value' => true,
            'domain_id' => null,
            'language_id' => null
        ],
    ],
    [
        'name' => 'title_separator',
        'required' => false,
        'autoload' => true,
        'status' => t2cms\sitemanager\models\Setting::STATUS['COMMON'],
        'defaultValue' => [
            'value' => ' - ',
            'domain_id' => null,
            'language_id' => null
        ],
    ],
    [
        'name' =>'resources_head',
        'required' => false,
        'autoload' => true,
        'status' => t2cms\sitemanager\models\Setting::STATUS['GENERAL'],
        'defaultValue' => [
            'value' => '',
            'domain_id' => null,
            'language_id' => null
        ],
    ],
    [
        'name' => 'resources_body',
        'required' => false,
        'autoload' => true,
        'status' => t2cms\sitemanager\models\Setting::STATUS['GENERAL'],
        'defaultValue' => [
            'value' => '',
            'domain_id' => null,
            'language_id' => null
        ],
    ],
    /* analytics */
    [
        'name' => 'id_google_analytics',
        'required' => false,
        'autoload' => true,
        'status' => t2cms\sitemanager\models\Setting::STATUS['MAIN'],
        'defaultValue' => [
            'value' => '',
            'domain_id' => null,
            'language_id' => null
        ],
    ],
    [
        'name' => 'google_webmaster',
        'required' => false,
        'autoload' => true,
        'status' => t2cms\sitemanager\models\Setting::STATUS['MAIN'],
        'defaultValue' => [
            'value' => '',
            'domain_id' => null,
            'language_id' => null
        ],
    ],
    [
        'name' => 'yandex_webmaster',
        'required' => false,
        'autoload' => true,
        'status' => t2cms\sitemanager\models\Setting::STATUS['MAIN'],
        'defaultValue' => [
            'value' => '',
            'domain_id' => null,
            'language_id' => null
        ],
    ],
    [
        'name' => 'id_yandex_metrika',
        'required' => false,
        'autoload' => true,
        'status' => t2cms\sitemanager\models\Setting::STATUS['MAIN'],
        'defaultValue' => [
            'value' => '',
            'domain_id' => null,
            'language_id' => null
        ],
    ],
    /* city name */
    [
        'name' => 'city',
        'required' => false,
        'autoload' => false,
        'status' => t2cms\sitemanager\models\Setting::STATUS['MAIN'],
        'defaultValue' => [
            'value' => 'city 0',
            'domain_id' => null,
            'language_id' => null
        ],
    ],
    [
        'name' => 'city_1',
        'required' => false,
        'autoload' => false,
        'status' => t2cms\sitemanager\models\Setting::STATUS['MAIN'],
        'defaultValue' => [
            'value' => 'city 1',
            'domain_id' => null,
            'language_id' => null
        ],
    ],
    [
        'name' => 'city_2',
        'required' => false,
        'autoload' => false,
        'status' => t2cms\sitemanager\models\Setting::STATUS['MAIN'],
        'defaultValue' => [
            'value' => 'city 2',
            'domain_id' => null,
            'language_id' => null
        ],
    ],
    [
        'name' => 'city_3',
        'required' => false,
        'autoload' => false,
        'status' => t2cms\sitemanager\models\Setting::STATUS['MAIN'],
        'defaultValue' => [
            'value' => 'city 3',
            'domain_id' => null,
            'language_id' => null
        ],
    ],
    [
        'name' => 'city_4',
        'required' => false,
        'autoload' => false,
        'status' => t2cms\sitemanager\models\Setting::STATUS['MAIN'],
        'defaultValue' => [
            'value' => 'city 4',
            'domain_id' => null,
            'language_id' => null
        ],
    ],
    [
        'name' => 'city_5',
        'required' => false,
        'autoload' => false,
        'status' => t2cms\sitemanager\models\Setting::STATUS['MAIN'],
        'defaultValue' => [
            'value' => 'city 5',
            'domain_id' => null,
            'language_id' => null
        ],
    ],
    /* contact details */
    [
        'name' => 'address',
        'required' => false,
        'autoload' => false,
        'status' => t2cms\sitemanager\models\Setting::STATUS['MAIN'],
        'defaultValue' => [
            'value' => '',
            'domain_id' => null,
            'language_id' => null
        ],
    ],
    [
        'name' => 'phone',
        'required' => false,
        'autoload' => false,
        'status' => t2cms\sitemanager\models\Setting::STATUS['MAIN'],
        'defaultValue' => [
            'value' => '',
            'domain_id' => null,
            'language_id' => null
        ],
    ],
    [
        'name' => 'email',
        'required' => false,
        'autoload' => false,
        'status' => t2cms\sitemanager\models\Setting::STATUS['MAIN'],
        'defaultValue' => [
            'value' => '',
            'domain_id' => null,
            'language_id' => null
        ],
    ],
    [
        'name' => 'email_feedback',
        'required' => false,
        'autoload' => false,
        'status' => t2cms\sitemanager\models\Setting::STATUS['MAIN'],
        'defaultValue' => [
            'value' => '',
            'domain_id' => null,
            'language_id' => null
        ],
    ],
    [
        'name' => 'email_from',
        'required' => false,
        'autoload' => false,
        'status' => t2cms\sitemanager\models\Setting::STATUS['MAIN'],
        'defaultValue' => [
            'value' => 'robot@mysite.com',
            'domain_id' => null,
            'language_id' => null
        ],
    ],
    [
        'name' => 'price_link',
        'required' => false,
        'autoload' => false,
        'status' => t2cms\sitemanager\models\Setting::STATUS['MAIN'],
        'defaultValue' => [
            'value' => '',
            'domain_id' => null,
            'language_id' => null
        ],
    ],
];