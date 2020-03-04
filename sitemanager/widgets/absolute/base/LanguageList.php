<?php

/**
 * @link https://github.com/t2cms/sitemanager
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms-core/sitemanager/blob/master/LICENSE
 */

namespace t2cms\sitemanager\widgets\absolute\base;

use t2cms\sitemanager\repositories\read\LanguageReadRepository;

/**
 * Generates select tag with all languages
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class LanguageList extends baseSelect{
    /**
     * @var string name of select tag 
     */
    protected $selectName  = "langauge";
    
    /**
     * @var string session admin name for controll content
     */
    protected $sessionName = "_language";
    
    public function __construct(LanguageReadRepository $repository, $config = [])
    {
        parent::__construct($repository, $config);
    }
}
