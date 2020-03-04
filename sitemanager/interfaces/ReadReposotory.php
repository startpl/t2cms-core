<?php

/**
 * @link https://github.com/startpl/t2cms
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms/blob/master/LICENSE
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
     * Gets models by parent id
     * 
     * @param int $id
     * @return array|null
     */
    public function getById(int $id): ?array;    
    
    /**
     * Gets all models
     * 
     * @return array|null
     */
    public function getAll(): ?array;
}
