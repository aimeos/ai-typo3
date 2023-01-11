<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2022-2023
 */


namespace Aimeos\Upscheme\Task;


class CustomerClearPropertyKeyTypo3 extends TablesMigratePropertyKey
{
	protected function tables()
	{
		return [
			'db-customer' => 'fe_users_property',
		];
	}
}
