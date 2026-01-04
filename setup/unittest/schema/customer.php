<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2026
 */


return array(
	'table' => array(

		'fe_users' => function( \Aimeos\Upscheme\Schema\Table $table ) {

			$table->id( 'uid' )->unsigned( true )->primary( 'PRIMARY' );
			$table->string( 'siteid' )->default( '1.' );
			$table->int( 'pid' )->unsigned( true )->default( 0 );
			$table->int( 'deleted' )->length( 3 )->default( 0 );
			$table->int( 'hidden' )->length( 3 )->default( 0 );
			$table->int( 'disable' )->unsigned( true )->length( 3 )->default( 0 );
			$table->int( 'tstamp' )->unsigned( true )->default( 0 );
			$table->int( 'crdate' )->unsigned( true )->default( 0 );
			$table->int( 'cruser_id' )->unsigned( true )->default( 0 );
			$table->string( 'lockToDomain' )->length( 50 )->default( '' );
			$table->text( 'TSconfig' )->default( '' );
			$table->int( 'starttime' )->unsigned( true )->length( 11 )->default( 0 );
			$table->int( 'endtime' )->unsigned( true )->length( 11 )->default( 0 );
			$table->string( 'usergroup' )->null( true );
			$table->string( 'name' )->length( 100 )->default( '' );
			$table->text( 'uc' )->null( true );
			$table->string( 'username' )->length( 50 )->null( true );
			$table->string( 'password' )->length( 100 )->null( true );
			$table->string( 'first_name' )->length( 50 )->null( true );
			$table->string( 'middle_name' )->length( 50 )->null( true );
			$table->string( 'last_name' )->length( 50 )->null( true );
			$table->string( 'address' )->null( true );
			$table->string( 'telephone' )->length( 20 )->null( true );
			$table->string( 'fax' )->length( 20 )->null( true );
			$table->string( 'mobile', 32 )->default( '' );
			$table->string( 'email' )->length( 80 )->null( true );
			$table->string( 'title' )->length( 40 )->null( true );
			$table->string( 'city' )->length( 50 )->null( true );
			$table->string( 'www' )->length( 80 )->null( true );
			$table->string( 'company' )->length( 80 )->null( true );
			$table->string( 'vatid' )->length( 50 )->null( true );
			$table->string( 'zip' )->length( 20 )->default( '' );
			$table->string( 'country' )->length( 60 )->default( '' );
			$table->text( 'image', 255 )->null( true );
			$table->string( 'felogin_forgotHash' )->length( 80 )->null( true );
			$table->string( 'tx_extbase_type' )->null( true );
			$table->int( 'fe_cruser_id' )->unsigned( true )->default( 0 );
			$table->int( 'lastlogin' )->unsigned( true )->default( 0 );
			$table->int( 'is_online' )->unsigned( true )->default( 0 );
			$table->int( 'date_of_birth' )->unsigned( true )->default( 0 );
			$table->string( 'zone' )->length( 45 )->default( '' );
			$table->string( 'language' )->length( 2 )->default( '' );
			$table->string( 'cnum' )->length( 50 )->default( '' );
			$table->string( 'token' )->length( 32 )->default( '' );
			$table->int( 'gender' )->unsigned( true )->default( 99 );
			$table->int( 'status' )->unsigned( true )->default( 0 );
			$table->int( 'by_invitation' )->unsigned( true )->default( 0 );
			$table->int( 'module_sys_dmail_html' )->unsigned( true )->default( 0 );
			$table->int( 'terms_acknowledged' )->unsigned( true )->default( 0 );
			$table->text( 'tx_srfeuserregister_password' )->default( '' );
			$table->text( 'comments' )->default( '' );
			$table->text( 'felogin_redirectPid' )->length( 0xff )->default( '' );
			$table->string( 'static_info_country' )->length( 3 )->default( '' );
			$table->float( 'longitude' )->null( true )->default( null );
			$table->float( 'latitude' )->null( true )->default( null );
			$table->date( 'vdate' )->null( true );
			$table->string( 'editor' )->default( '' );

			$table->index( ['pid', 'username'], 'fe_users_parent' );
			$table->index( ['username'], 'fe_users_username' );
			$table->index( ['is_online'], 'fe_users_is_online' );
		},

		'fe_groups' => function( \Aimeos\Upscheme\Schema\Table $table ) {

			$table->id( 'uid' )->unsigned( true )->primary( 'PRIMARY' );
			$table->int( 'pid' )->unsigned( true )->default( 0 );
			$table->int( 'deleted' )->length( 3 )->default( 0 );
			$table->int( 'hidden' )->length( 3 )->default( 0 );
			$table->int( 'tstamp' )->unsigned( true )->default( 0 );
			$table->int( 'crdate' )->unsigned( true )->default( 0 );
			$table->int( 'cruser_id' )->unsigned( true )->default( 0 );
			$table->string( 'title' )->length( 50 )->default( '' );
			$table->string( 'lockToDomain' )->length( 50 )->default( '' );
			$table->text( 'description' )->default( '' );
			$table->text( 'TSconfig' )->default( '' );
			$table->text( 'subgroup' )->length( 0xff )->default( '' );
			$table->text( 'felogin_redirectPid' )->length( 0xff )->null( true );
			$table->int( 'tx_phpunit_is_dummy_record' )->unsigned( true )->length( 1 )->default( 0 );

			$table->index( ['pid', 'deleted', 'hidden'], 'fe_groups_parent' );
		},
	),
);
