<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2020
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Creates all required TYPO3 tables.
 */
class TablesAddTypo3TestData extends TablesCreateMShop
{
	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return string[] List of task names
	 */
	public function getPostDependencies() : array
	{
		return ['TablesCreateMShop'];
	}


	/**
	 * Creates the TYPO3 test tables
	 */
	public function migrate()
	{
		$this->msg( 'Creating TYPO3 test tables', 0, '' );

		$ds = DIRECTORY_SEPARATOR;

		$this->setupSchema( ['db-customer' => 'schema' . $ds . 'customer.php'] );

		$this->execute( "
			INSERT INTO static_countries (pid, deleted, cn_iso_2, cn_iso_3, cn_iso_nr, cn_parent_tr_iso_nr, cn_official_name_local, cn_official_name_en, cn_capital, cn_tldomain, cn_currency_iso_3, cn_currency_iso_nr, cn_phone, cn_eu_member, cn_address_format, cn_zone_flag, cn_short_local, cn_short_en, cn_uno_member)
			SELECT 0, 0, 'DE', 'DEU', 276, 155, 'Bundesrepublik Deutschland', 'Federal Republic of Germany', 'Berlin', 'de', 'EUR', 978, 49, 1, 1, 0, 'Deutschland', 'Germany', 1 WHERE NOT EXISTS ( SELECT cn_iso_2 FROM static_countries WHERE cn_iso_2 = 'DE' );
		" );
	}
}
