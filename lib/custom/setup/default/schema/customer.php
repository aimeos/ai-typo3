<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2018
 */


return array(
	'table' => array(

		'fe_users_address' => function ( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'fe_users_address' );

			$table->addColumn( 'id', 'integer', array( 'autoincrement' => true ) );
			$table->addColumn( 'siteid', 'integer', ['notnull' => false] );
			$table->addColumn( 'parentid', 'integer', ['unsigned' => true] );
			$table->addColumn( 'pos', 'smallint', [] );
			$table->addColumn( 'company', 'string', array( 'length' => 100 ) );
			$table->addColumn( 'vatid', 'string', array( 'length' => 32 ) );
			$table->addColumn( 'salutation', 'string', array( 'length' => 8 ) );
			$table->addColumn( 'title', 'string', array( 'length' => 64 ) );
			$table->addColumn( 'firstname', 'string', array( 'length' => 64 ) );
			$table->addColumn( 'lastname', 'string', array( 'length' => 64 ) );
			$table->addColumn( 'address1', 'string', array( 'length' => 200 ) );
			$table->addColumn( 'address2', 'string', array( 'length' => 200 ) );
			$table->addColumn( 'address3', 'string', array( 'length' => 200 ) );
			$table->addColumn( 'postal', 'string', array( 'length' => 16 ) );
			$table->addColumn( 'city', 'string', array( 'length' => 200 ) );
			$table->addColumn( 'state', 'string', array( 'length' => 200 ) );
			$table->addColumn( 'langid', 'string', array( 'length' => 5, 'notnull' => false ) );
			$table->addColumn( 'countryid', 'string', array( 'length' => 2, 'notnull' => false ) );
			$table->addColumn( 'telephone', 'string', array( 'length' => 32 ) );
			$table->addColumn( 'telefax', 'string', array( 'length' => 32 ) );
			$table->addColumn( 'email', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'website', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'longitude', 'float', array( 'notnull' => false ) );
			$table->addColumn( 'latitude', 'float', array( 'notnull' => false ) );
			$table->addColumn( 'mtime', 'datetime', [] );
			$table->addColumn( 'ctime', 'datetime', [] );
			$table->addColumn( 'editor', 'string', array('length' => 255 ) );

			$table->setPrimaryKey( array( 'id' ), 'pk_t3feuad_id' );
			$table->addIndex( array( 'lastname', 'firstname' ), 'idx_t3feuad_last_first' );
			$table->addIndex( array( 'postal', 'address1' ), 'idx_t3feuad_post_addr1' );
			$table->addIndex( array( 'postal', 'city' ), 'idx_t3feuad_post_city' );
			$table->addIndex( array( 'address1' ), 'idx_t3feuad_address1' );
			$table->addIndex( array( 'city' ), 'idx_t3feuad_city' );
			$table->addIndex( array( 'email' ), 'idx_t3feuad_email' );
			$table->addIndex( array( 'parentid' ), 'fk_t3feuad_pid' );

			$table->addForeignKeyConstraint( 'fe_users', array( 'parentid' ), array( 'uid' ),
				array( 'onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE' ), 'fk_t3feuad_pid' );

			return $schema;
		},

		'fe_users_list_type' => function ( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'fe_users_list_type' );

			$table->addColumn( 'id', 'integer', array( 'autoincrement' => true ) );
			$table->addColumn( 'siteid', 'integer', [] );
			$table->addColumn( 'domain', 'string', array( 'length' => 32 ) );
			$table->addColumn( 'code', 'string', array( 'length' => 64 ) );
			$table->addColumn( 'label', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'pos', 'integer', ['default' => 0] );
			$table->addColumn( 'status', 'smallint', [] );
			$table->addColumn( 'mtime', 'datetime', [] );
			$table->addColumn( 'ctime', 'datetime', [] );
			$table->addColumn( 'editor', 'string', array( 'length' => 255 ) );

			$table->setPrimaryKey( array( 'id' ), 'pk_t3feulity_id' );
			$table->addUniqueIndex( array( 'siteid', 'domain', 'code' ), 'unq_t3feulity_sid_dom_code' );
			$table->addIndex( array( 'siteid', 'status', 'pos' ), 'idx_t3feulity_sid_status_pos' );
			$table->addIndex( array( 'siteid', 'label' ), 'idx_t3feulity_sid_label' );
			$table->addIndex( array( 'siteid', 'code' ), 'idx_t3feulity_sid_code' );

			return $schema;
		},

		'fe_users_list' => function ( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'fe_users_list' );

			$table->addColumn( 'id', 'integer', array( 'autoincrement' => true ) );
			$table->addColumn( 'parentid', 'integer', ['unsigned' => true] );
			$table->addColumn( 'siteid', 'integer', [] );
			$table->addColumn( 'key', 'string', array( 'length' => 134, 'default' => '', 'customSchemaOptions' => ['charset' => 'binary'] ) );
			$table->addColumn( 'type', 'string', array( 'length' => 64 ) );
			$table->addColumn( 'domain', 'string', array( 'length' => 32 ) );
			$table->addColumn( 'refid', 'string', array( 'length' => 36, 'customSchemaOptions' => ['charset' => 'binary'] ) );
			$table->addColumn( 'start', 'datetime', array( 'notnull' => false ) );
			$table->addColumn( 'end', 'datetime', array( 'notnull' => false ) );
			$table->addColumn( 'config', 'text', array( 'length' => 0xffff ) );
			$table->addColumn( 'pos', 'integer', [] );
			$table->addColumn( 'status', 'smallint', [] );
			$table->addColumn( 'mtime', 'datetime', [] );
			$table->addColumn( 'ctime', 'datetime', [] );
			$table->addColumn( 'editor', 'string', array( 'length' => 255 ) );

			$table->setPrimaryKey( array( 'id' ), 'pk_t3feuli_id' );
			$table->addUniqueIndex( array( 'parentid', 'siteid', 'domain', 'type', 'refid' ), 'unq_t3feuli_pid_sid_dm_ty_rid' );
			$table->addIndex( array( 'siteid', 'key' ), 'idx_t3feuli_sid_key' );
			$table->addIndex( array( 'parentid' ), 'fk_t3feuli_pid' );

			$table->addForeignKeyConstraint( 'fe_users', array( 'parentid' ), array( 'uid' ),
				array( 'onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE' ), 'fk_t3feuli_pid' );

			return $schema;
		},

		'fe_users_property_type' => function ( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'fe_users_property_type' );

			$table->addColumn( 'id', 'integer', array( 'autoincrement' => true ) );
			$table->addColumn( 'siteid', 'integer', [] );
			$table->addColumn( 'domain', 'string', array( 'length' => 32 ) );
			$table->addColumn( 'code', 'string', array( 'length' => 64 ) );
			$table->addColumn( 'label', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'pos', 'integer', ['default' => 0] );
			$table->addColumn( 'status', 'smallint', [] );
			$table->addColumn( 'mtime', 'datetime', [] );
			$table->addColumn( 'ctime', 'datetime', [] );
			$table->addColumn( 'editor', 'string', array( 'length' => 255 ) );

			$table->setPrimaryKey( array( 'id' ), 'pk_t3feuprty_id' );
			$table->addUniqueIndex( array( 'siteid', 'domain', 'code' ), 'unq_t3feuprty_sid_dom_code' );
			$table->addIndex( array( 'siteid', 'status', 'pos' ), 'idx_t3feuprty_sid_status_pos' );
			$table->addIndex( array( 'siteid', 'label' ), 'idx_t3feuprty_sid_label' );
			$table->addIndex( array( 'siteid', 'code' ), 'idx_t3feuprty_sid_code' );

			return $schema;
		},

		'fe_users_property' => function ( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'fe_users_property' );

			$table->addColumn( 'id', 'integer', array( 'autoincrement' => true ) );
			$table->addColumn( 'parentid', 'integer', ['unsigned' => true] );
			$table->addColumn( 'siteid', 'integer', [] );
			$table->addColumn( 'key', 'string', array( 'length' => 103, 'default' => '', 'customSchemaOptions' => ['charset' => 'binary'] ) );
			$table->addColumn( 'type', 'string', array( 'length' => 64 ) );
			$table->addColumn( 'langid', 'string', array( 'length' => 5, 'notnull' => false ) );
			$table->addColumn( 'value', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'mtime', 'datetime', [] );
			$table->addColumn( 'ctime', 'datetime', [] );
			$table->addColumn( 'editor', 'string', array( 'length' => 255 ) );

			$table->setPrimaryKey( array( 'id' ), 'pk_t3feupr_id' );
			$table->addUniqueIndex( array( 'parentid', 'siteid', 'type', 'langid', 'value' ), 'unq_t3feupr_sid_ty_lid_value' );
			$table->addIndex( array( 'siteid', 'key' ), 'fk_t3feupr_sid_key' );
			$table->addIndex( array( 'parentid' ), 'fk_t3feupr_pid' );

			$table->addForeignKeyConstraint( 'fe_users', array( 'parentid' ), array( 'uid' ),
				array( 'onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE' ), 'fk_t3feupr_pid' );

			return $schema;
		},
	),
);
