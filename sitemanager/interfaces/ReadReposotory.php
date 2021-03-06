<?php

/**
 * @link https://github.com/startpl/t2cms-core/sitemanager
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms-core/sitemanager/blob/master/LICENSE
 */

namespace t2cms\sitemanager\interfaces;

/**
 * Interface for ReadRepository
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
interface ReadReposotory {
    
    /**
     * Gets model by id
     * 
     * @param int $id
     * @return array|null
     */
    public function getById(int $id): ?array;    
}