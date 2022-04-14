<?php

/**
 * @license LGPLv3, https://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2021-2022
 */


namespace Aimeos\Upscheme\Task;


class CustomerAddFeusers extends Base
{
	public function before() : array
	{
		return ['Customer'];
	}


	public function up()
	{
		$this->info( 'Creating fe_users schema', 'vv' );
		$db = $this->db( 'db-customer' );

		$filepath = __DIR__ . '/schema/customer.php';

		if( ( $list = include( $filepath ) ) === false ) {
			throw new \RuntimeException( sprintf( 'Unable to get schema from file "%1$s"', $filepath ) );
		}

		foreach( $list['table'] ?? [] as $name => $fcn ) {
			$db->table( $name, $fcn );
		}
	}
}
