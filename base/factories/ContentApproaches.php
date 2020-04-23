<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\base\factories;

/**
 * Description of ContentApproaches
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 */
class ContentApproaches 
{
    public static function getApproaches($domain_id, $language_id): array
    {
        return [
            [
                'domain_id' => $domain_id,
                'language_id' => $language_id
            ],
            [
                'domain_id' => $domain_id,
                'language_id' => null
            ],
            [
                'domain_id' => \t2cms\sitemanager\repositories\DomainRepository::getDefaultId(),
                'language_id' => $language_id
            ],
            [
                'domain_id' => \t2cms\sitemanager\repositories\DomainRepository::getDefaultId(),
                'language_id' => null
            ],
            [
                'domain_id' => null,
                'language_id' => $language_id
            ],
            [
                'domain_id' => null,
                'language_id' => null
            ]
        ];
    }
}
