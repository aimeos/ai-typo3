<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2021
 */


return array(
	'table' => array(

		'fe_users' => function( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'fe_users' );

			$table->addColumn( 'siteid', 'string', ['length' => 255, 'default' => '1.'] );
			$table->addColumn( 'uid', 'integer', ['autoincrement' => true, 'unsigned' => true] );
			$table->addColumn( 'pid', 'integer', ['unsigned' => true, 'default' => 0] );
			$table->addColumn( 'deleted', 'integer', ['length' => 3, 'default' => 0] );
			$table->addColumn( 'hidden', 'integer', ['length' => 3, 'default' => 0] );
			$table->addColumn( 'disable', 'integer', ['length' => 3, 'unsigned' => true, 'default' => 0] );
			$table->addColumn( 'tstamp', 'integer', ['unsigned' => true, 'default' => 0] );
			$table->addColumn( 'crdate', 'integer', ['unsigned' => true, 'default' => 0] );
			$table->addColumn( 'cruser_id', 'integer', ['unsigned' => true, 'default' => 0] );
			$table->addColumn( 'lockToDomain', 'string', ['length' => 50, 'default' => ''] );
			$table->addColumn( 'TSconfig', 'text', ['length' => 0xffff, 'default' => ''] );
			$table->addColumn( 'starttime', 'integer', ['length' => 11, 'unsigned' => true, 'default' => 0] );
			$table->addColumn( 'endtime', 'integer', ['length' => 11, 'unsigned' => true, 'default' => 0] );
			$table->addColumn( 'usergroup', 'string', ['length' => 0xff, 'notnull' => false] );
			$table->addColumn( 'name', 'string', ['length' => 100, 'default' => ''] );
			$table->addColumn( 'uc', 'text', ['length' => 0xffff, 'notnull' => false] );
			$table->addColumn( 'username', 'string', ['length' => 50, 'notnull' => false] );
			$table->addColumn( 'password', 'string', ['length' => 40, 'notnull' => false] );
			$table->addColumn( 'first_name', 'string', ['length' => 50, 'notnull' => false] );
			$table->addColumn( 'middle_name', 'string', ['length' => 50, 'notnull' => false] );
			$table->addColumn( 'last_name', 'string', ['length' => 50, 'notnull' => false] );
			$table->addColumn( 'address', 'string', ['length' => 255, 'notnull' => false] );
			$table->addColumn( 'telephone', 'string', ['length' => 20, 'notnull' => false] );
			$table->addColumn( 'fax', 'string', ['length' => 20, 'notnull' => false] );
			$table->addColumn( 'email', 'string', ['length' => 80, 'notnull' => false] );
			$table->addColumn( 'title', 'string', ['length' => 40, 'notnull' => false] );
			$table->addColumn( 'city', 'string', ['length' => 50, 'notnull' => false] );
			$table->addColumn( 'www', 'string', ['length' => 80, 'notnull' => false] );
			$table->addColumn( 'company', 'string', ['length' => 80, 'notnull' => false] );
			$table->addColumn( 'vatid', 'string', ['length' => 32, 'notnull' => false] );
			$table->addColumn( 'zip', 'string', ['length' => 20, 'default' => ''] );
			$table->addColumn( 'country', 'string', ['length' => 60, 'default' => ''] );
			$table->addColumn( 'image', 'text', ['length' => 0xff, 'notnull' => false] );
			$table->addColumn( 'felogin_forgotHash', 'string', ['length' => 80, 'notnull' => false] );
			$table->addColumn( 'tx_extbase_type', 'string', ['length' => 255, 'notnull' => false] );
			$table->addColumn( 'fe_cruser_id', 'integer', ['unsigned' => true, 'default' => 0] );
			$table->addColumn( 'lastlogin', 'integer', ['unsigned' => true, 'default' => 0] );
			$table->addColumn( 'is_online', 'integer', ['unsigned' => true, 'default' => 0] );
			$table->addColumn( 'date_of_birth', 'integer', ['unsigned' => true, 'default' => 0] );
			$table->addColumn( 'zone', 'string', ['length' => 45, 'default' => ''] );
			$table->addColumn( 'language', 'string', ['length' => 2, 'default' => ''] );
			$table->addColumn( 'cnum', 'string', ['length' => 50, 'default' => ''] );
			$table->addColumn( 'token', 'string', ['length' => 32, 'default' => ''] );
			$table->addColumn( 'gender', 'integer', ['unsigned' => true, 'default' => 99] );
			$table->addColumn( 'status', 'integer', ['unsigned' => true, 'default' => 0] );
			$table->addColumn( 'by_invitation', 'integer', ['unsigned' => true, 'default' => 0] );
			$table->addColumn( 'module_sys_dmail_html', 'integer', ['unsigned' => true, 'default' => 0] );
			$table->addColumn( 'terms_acknowledged', 'integer', ['unsigned' => true, 'default' => 0] );
			$table->addColumn( 'tx_srfeuserregister_password', 'text', ['length' => 0xffff, 'default' => ''] );
			$table->addColumn( 'comments', 'text', ['length' => 0xffff, 'default' => ''] );
			$table->addColumn( 'felogin_redirectPid', 'text', ['length' => 0xff, 'default' => ''] );
			$table->addColumn( 'static_info_country', 'string', ['length' => 3, 'default' => ''] );
			$table->addColumn( 'longitude', 'decimal', ['precision' => 8, 'scale' => 6, 'notnull' => false] );
			$table->addColumn( 'latitude', 'decimal', ['precision' => 8, 'scale' => 6, 'notnull' => false] );

			$table->setPrimaryKey( ['uid'], 'PRIMARY' );
			$table->addIndex( ['pid', 'username'], 'fe_users_parent' );
			$table->addIndex( ['username'], 'fe_users_username' );
			$table->addIndex( ['is_online'], 'fe_users_is_online' );

			return $schema;
		},

		'fe_groups' => function( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'fe_groups' );

			$table->addColumn( 'uid', 'integer', ['autoincrement' => true, 'unsigned' => true] );
			$table->addColumn( 'pid', 'integer', ['unsigned' => true, 'default' => 0] );
			$table->addColumn( 'deleted', 'integer', ['length' => 3, 'default' => 0] );
			$table->addColumn( 'hidden', 'integer', ['length' => 3, 'default' => 0] );
			$table->addColumn( 'tstamp', 'integer', ['unsigned' => true, 'default' => 0] );
			$table->addColumn( 'crdate', 'integer', ['unsigned' => true, 'default' => 0] );
			$table->addColumn( 'cruser_id', 'integer', ['unsigned' => true, 'default' => 0] );
			$table->addColumn( 'title', 'string', ['length' => 50, 'default' => ''] );
			$table->addColumn( 'lockToDomain', 'string', ['length' => 50, 'default' => ''] );
			$table->addColumn( 'description', 'text', ['length' => 0xffff, 'default' => ''] );
			$table->addColumn( 'TSconfig', 'text', ['length' => 0xffff, 'default' => ''] );
			$table->addColumn( 'subgroup', 'text', ['length' => 0xff, 'default' => ''] );
			$table->addColumn( 'felogin_redirectPid', 'text', ['length' => 0xff, 'notnull' => false] );
			$table->addColumn( 'tx_phpunit_is_dummy_record', 'integer', ['unsigned' => true, 'length' => 1, 'default' => 0] );

			$table->setPrimaryKey( ['uid'], 'PRIMARY' );
			$table->addIndex( ['pid', 'deleted', 'hidden'], 'fe_groups_parent' );

			return $schema;
		},
	),
);
