<?php

/**
 * @license LGPLv3, https://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2022-2023
 */


namespace Aimeos\Upscheme\Task;


class CustomerRemoveIndexesTypo3 extends Base
{
	public function after() : array
	{
		return ['Customer'];
	}


	public function up()
	{
		$this->info( 'Remove customer indexes with siteid column first', 'vv' );

		$this->db( 'db-customer' )
			->dropIndex( 'fe_users_address', 'idx_t3feuad_langid' )
			->dropIndex( 'fe_users_address', 'idx_t3feuad_sid_last_first' )
			->dropIndex( 'fe_users_address', 'idx_t3feuad_sid_post_addr1' )
			->dropIndex( 'fe_users_address', 'idx_t3feuad_sid_post_ci' )
			->dropIndex( 'fe_users_address', 'idx_t3feuad_sid_city' )
			->dropIndex( 'fe_users_address', 'idx_t3feuad_sid_email' )
			->dropIndex( 'fe_users_list', 'unq_t3feuli_pid_dm_sid_ty_rid' )
			->dropIndex( 'fe_users_list_type', 'unq_t3feulity_sid_dom_code' )
			->dropIndex( 'fe_users_list_type', 'idx_t3feulity_sid_status_pos' )
			->dropIndex( 'fe_users_list_type', 'idx_t3feulity_sid_label' )
			->dropIndex( 'fe_users_list_type', 'idx_t3feulity_sid_code' )
			->dropIndex( 'fe_users_property', 'fk_t3feupr_key_sid' )
			->dropIndex( 'fe_users_property', 'unq_t3feupr_sid_ty_lid_value' )
			->dropIndex( 'fe_users_property_type', 'unq_t3feuprty_sid_dom_code' )
			->dropIndex( 'fe_users_property_type', 'idx_t3feuprty_sid_status_pos' )
			->dropIndex( 'fe_users_property_type', 'idx_t3feuprty_sid_label' )
			->dropIndex( 'fe_users_property_type', 'idx_t3feuprty_sid_code' )
			->dropIndex( 'fe_users_property_type', 'fk_t3feupr_key_sid' );
	}
}
