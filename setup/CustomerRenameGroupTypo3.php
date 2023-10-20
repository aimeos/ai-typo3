<?php

/**
 * @license LGPLv3, https://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2023
 */


namespace Aimeos\Upscheme\Task;


class CustomerRenameGroupTypo3 extends CustomerRenameGroup
{
	public function before() : array
	{
		return ['Customer', 'Group'];
	}


	public function up()
	{
		$this->info( 'Migrate TYPO3 "customer/group" domain to "group"', 'vv' );

		$this->update( 'fe_users_list' );
	}
}
