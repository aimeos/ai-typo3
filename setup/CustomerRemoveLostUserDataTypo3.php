<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2018-2024
 */


namespace Aimeos\Upscheme\Task;


/**
 * Removes address and list records without user entry
 */
class CustomerRemoveLostUserDataTypo3 extends Base
{
	private $sql = [
		'fe_users_address' => [
			'fk_mcusad_pid' => 'DELETE FROM fe_users_address WHERE NOT EXISTS ( SELECT uid FROM fe_users AS u WHERE parentid=u.uid )'
		],
		'fe_users_list' => [
			'fk_mcusli_pid' => 'DELETE FROM fe_users_list WHERE NOT EXISTS ( SELECT uid FROM fe_users AS u WHERE parentid=u.uid )'
		],
		'fe_users_property' => [
			'fk_mcuspr_pid' => 'DELETE FROM fe_users_property WHERE NOT EXISTS ( SELECT uid FROM fe_users AS u WHERE parentid=u.uid )'
		]
	];


	/**
	 * Returns the list of task names which depends on this task.
	 *
	 * @return string[] List of task names
	 */
	public function before() : array
	{
		return ['Customer'];
	}


	/**
	 * Migrate database schema
	 */
	public function up()
	{
		$db = $this->db( 'db-customer' );

		if( !$db->hasTable( 'fe_users' ) ) {
			return;
		}

		$this->info( 'Remove left over TYPO3 fe_users references', 'vv' );

		foreach( $this->sql as $table => $map )
		{
			foreach( $map as $constraint => $sql )
			{
				if( $db->hasTable( $table ) && !$db->hasForeign( $table, $constraint ) )
				{
					$this->info( sprintf( 'Remove records from %1$s', $table ), 'vv', 1 );
					$db->exec( $sql );
				}
			}
		}
	}
}
