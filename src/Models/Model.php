<?php

namespace BSLCore\Models;

use Illuminate\Database\Eloquent\Model as DefaultModel;

class Model extends DefaultModel
{
    protected $mainTablePrefix = 'bsl_';

    protected $moduleTablePrefix = 'core_';

	public function getTable()
	{
		return $this->mainTablePrefix.$this->moduleTablePrefix.parent::getTable();
	}
}
