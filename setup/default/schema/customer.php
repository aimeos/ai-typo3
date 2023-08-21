<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2023
 */


return array(
	'table' => array(

		'fe_users_address' => function( \Aimeos\Upscheme\Schema\Table $table ) {

			$table->engine = 'InnoDB';

			$table->id()->primary( 'pk_t3feuad_id' );
			$table->string( 'siteid' );
			$table->int( 'parentid' );
			$table->string( 'company', 100 );
			$table->string( 'vatid', 32 );
			$table->string( 'salutation', 8 );
			$table->string( 'title', 64 );
			$table->string( 'firstname', 64 );
			$table->string( 'lastname', 64 );
			$table->string( 'address1', 200 );
			$table->string( 'address2', 200 );
			$table->string( 'address3', 200 );
			$table->string( 'postal', 16 );
			$table->string( 'city', 200 );
			$table->string( 'state', 200 );
			$table->string( 'langid', 5 )->null( true );
			$table->string( 'countryid', 2 )->null( true );
			$table->string( 'telephone', 32 );
			$table->string( 'telefax', 32 );
			$table->string( 'mobile', 32 )->default( '' );
			$table->string( 'email' );
			$table->string( 'website' );
			$table->float( 'longitude' )->null( true );
			$table->float( 'latitude' )->null( true );
			$table->date( 'birthday' )->null( true );
			$table->smallint( 'pos' );
			$table->meta();

			$table->index( ['langid', 'siteid'], 'idx_t3feuad_langid_sid' );
			$table->index( ['lastname', 'firstname'], 'idx_t3feuad_last_first' );
			$table->index( ['postal', 'address1'], 'idx_t3feuad_post_addr1' );
			$table->index( ['postal', 'city'], 'idx_t3feuad_post_ci' );
			$table->index( ['city'], 'idx_t3feuad_city' );
			$table->index( ['email'], 'idx_t3feuad_email' );

			$table->foreign( 'parentid', 'fe_users', 'uid', 'fk_t3feuad_pid' );
		},

		'fe_users_list_type' => function( \Aimeos\Upscheme\Schema\Table $table ) {

			$table->engine = 'InnoDB';

			$table->id()->primary( 'pk_t3feulity_id' );
			$table->string( 'siteid' );
			$table->string( 'domain', 32 );
			$table->code();
			$table->string( 'label' );
			$table->int( 'pos' )->default( 0 );
			$table->smallint( 'status' );
			$table->meta();

			$table->unique( ['domain', 'code', 'siteid'], 'unq_t3feulity_dom_code_sid' );
			$table->index( ['status', 'siteid', 'pos'], 'idx_t3feulity_status_sid_pos' );
			$table->index( ['label', 'siteid'], 'idx_t3feulity_label_sid' );
			$table->index( ['code', 'siteid'], 'idx_t3feulity_code_sid' );
		},

		'fe_users_list' => function( \Aimeos\Upscheme\Schema\Table $table ) {

			$table->engine = 'InnoDB';

			$table->id()->primary( 'pk_t3feuli_id' );
			$table->string( 'siteid' );
			$table->int( 'parentid' );
			$table->string( 'key', 134 )->default( '' );
			$table->type( 'type' );
			$table->string( 'domain', 32 );
			$table->refid();
			$table->startend();
			$table->config();
			$table->int( 'pos' );
			$table->smallint( 'status' );
			$table->meta();

			$table->unique( ['parentid', 'domain', 'type', 'refid', 'siteid'], 'unq_t3feuli_pid_dm_ty_rid_sid' );
			$table->index( ['key', 'siteid'], 'idx_t3feuli_key_sid' );

			$table->foreign( 'parentid', 'fe_users', 'uid', 'fk_t3feuli_pid' );
		},

		'fe_users_property_type' => function( \Aimeos\Upscheme\Schema\Table $table ) {

			$table->engine = 'InnoDB';

			$table->id()->primary( 'pk_t3feuprty_id' );
			$table->string( 'siteid' );
			$table->string( 'domain', 32 );
			$table->code();
			$table->string( 'label' );
			$table->int( 'pos' )->default( 0 );
			$table->smallint( 'status' );
			$table->meta();

			$table->unique( ['domain', 'code', 'siteid'], 'unq_t3feuprty_dom_code_sid' );
			$table->index( ['status', 'siteid', 'pos'], 'idx_t3feuprty_status_sid_pos' );
			$table->index( ['label', 'siteid'], 'idx_t3feuprty_label_sid' );
			$table->index( ['code', 'siteid'], 'idx_t3feuprty_code_sid' );
		},

		'fe_users_property' => function( \Aimeos\Upscheme\Schema\Table $table ) {

			$table->engine = 'InnoDB';

			$table->id()->primary( 'pk_t3feupr_id' );
			$table->string( 'siteid' );
			$table->int( 'parentid' );
			$table->string( 'key', 255 )->default( '' );
			$table->type();
			$table->string( 'langid', 5 )->null( true );
			$table->string( 'value' );
			$table->meta();

			$table->unique( ['parentid', 'type', 'langid', 'value', 'siteid'], 'unq_t3feupr_pid_ty_lid_val_sid' );
			$table->index( ['key', 'siteid'], 'idx_t3feupr_key_sid' );

			$table->foreign( 'parentid', 'fe_users', 'uid', 'fk_t3feupr_pid' );
		},
	),
);
