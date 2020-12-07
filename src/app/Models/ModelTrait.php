<?php


namespace BSLCore\App\Models;


trait ModelTrait
{
    protected $mainTablePrefix = 'bsl_';

    protected $moduleTablePrefix = 'core_';

    public function getTable()
    {
        return $this->mainTablePrefix.$this->moduleTablePrefix.parent::getTable();
    }
}
