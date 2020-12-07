<?php


namespace BSLCore\App\Database;


interface MigrateInterface
{
	public function migrate(): void;
}
