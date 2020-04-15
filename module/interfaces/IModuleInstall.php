<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\module\interfaces;

/**
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 */
interface IModuleInstall 
{
    public function install(): bool;
    public function uninstall(): bool;
    public function activate(): bool;
    public function deactivate(): bool;
    public function update(): bool;
}
