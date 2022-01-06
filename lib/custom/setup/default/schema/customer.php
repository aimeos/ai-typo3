<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2022
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
			$table->string( 'email' );
			$table->string( 'website' );
			$table->float( 'longitude' )->null( true );
			$table->float( 'latitude' )->null( true );
			$table->date( 'birthday' )->null( true );
			$table->smallint( 'pos' );
			$table->meta();

			$table->index( ['parentid'], 'fk_t3feuad_pid' );
			$table->index( ['langid'], 'idx_t3feuad_langid' );
			$table->index( ['siteid', 'lastname', 'firstname'], 'idx_t3feuad_sid_last_first' );
			$table->index( ['siteid', 'postal', 'address1'], 'idx_t3feuad_sid_post_addr1' );
			$table->index( ['siteid', 'postal', 'city'], 'idx_t3feuad_sid_post_ci' );
			$table->index( ['siteid', 'city'], 'idx_t3feuad_sid_city' );
			$table->index( ['siteid', 'email'], 'idx_t3feuad_sid_email' );

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

			$table->unique( ['siteid', 'domain', 'code'], 'unq_t3feulity_sid_dom_code' );
			$table->index( ['siteid', 'status', 'pos'], 'idx_t3feulity_sid_status_pos' );
			$table->index( ['siteid', 'label'], 'idx_t3feulity_sid_label' );
			$table->index( ['siteid', 'code'], 'idx_t3feulity_sid_code' );
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
			$table->text( 'config' );
			$table->int( 'pos' );
			$table->smallint( 'status' );
			$table->meta();

			$table->unique( ['parentid', 'domain', 'siteid', 'type', 'refid'], 'unq_t3feuli_pid_dm_sid_ty_rid' );
			$table->index( ['key', 'siteid'], 'idx_t3feuli_key_sid' );
			$table->index( ['parentid'], 'fk_t3feuli_pid' );

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

			$table->unique( ['siteid', 'domain', 'code'], 'unq_t3feuprty_sid_dom_code' );
			$table->index( ['siteid', 'status', 'pos'], 'idx_t3feuprty_sid_status_pos' );
			$table->index( ['siteid', 'label'], 'idx_t3feuprty_sid_label' );
			$table->index( ['siteid', 'code'], 'idx_t3feuprty_sid_code' );
		},

		'fe_users_property' => function( \Aimeos\Upscheme\Schema\Table $table ) {

			$table->engine = 'InnoDB';

			$table->id()->primary( 'pk_t3feupr_id' );
			$table->string( 'siteid' );
			$table->int( 'parentid' );
			$table->string( 'key', 103 )->default( '' );
			$table->type();
			$table->string( 'langid', 5 )->null( true );
			$table->string( 'value' );
			$table->meta();

			$table->unique( ['parentid', 'siteid', 'type', 'langid', 'value'], 'unq_t3feupr_sid_ty_lid_value' );
			$table->index( ['key', 'siteid'], 'fk_t3feupr_key_sid' );
			$table->index( ['parentid'], 'fk_t3feupr_pid' );

			$table->foreign( 'parentid', 'fe_users', 'uid', 'fk_t3feupr_pid' );
		},
	),
);
