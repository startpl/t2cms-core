<?php

/**
 * @link https://github.com/t2cms/sitemanager
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms-core/sitemanager/blob/master/LICENSE
 */

namespace t2cms\sitemanager\widgets\local\base;

use t2cms\sitemanager\repositories\read\DomainReadRepository;

/**
 * Generates select tag with all domains
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class DomainList extends baseSelect{
    
    /**
     * @var string name of select tag 
     */
    protected $selectName = "domain";
    
    /**
     * @var string session admin name for controll content
     */
    protected $paramName = "domain";
    
    public function __construct(DomainReadRepository $repository, $config = [])
    {
        parent::__construct($repository, $config);
    }
}
