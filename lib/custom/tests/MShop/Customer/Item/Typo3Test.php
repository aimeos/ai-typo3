<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016
 */


namespace Aimeos\MShop\Customer\Item;


class Typo3Test extends \PHPUnit_Framework_TestCase
{
	private $object;


	protected function setUp()
	{
		$addressValues = array(
			'customer.address.parentid' => 'referenceid',
			'customer.address.position' => 1,
		);

		$address = new \Aimeos\MShop\Common\Item\Address\Standard( 'common.address.', $addressValues );

		$values = array(
			'customer.id' => 541,
			'customer.siteid' => 123,
			'customer.label' => 'unitObject',
			'customer.code' => '12345ABCDEF',
			'customer.birthday' => '2010-01-01',
			'customer.status' => 1,
			'customer.password' => '',
			'customer.vdate' => null,
			'customer.company' => 'unitCompany',
			'customer.vatid' => 'DE999999999',
			'customer.salutation' => \Aimeos\MShop\Common\Item\Address\Base::SALUTATION_MR,
			'customer.title' => 'Dr.',
			'customer.firstname' => 'firstunit',
			'customer.lastname' => 'lastunit',
			'customer.address1' => 'unit str.',
			'customer.address2' => ' 166',
			'customer.address3' => '4.OG',
			'customer.postal' => '22769',
			'customer.city' => 'Hamburg',
			'customer.state' => 'Hamburg',
			'customer.countryid' => 'de',
			'customer.languageid' => 'de',
			'customer.telephone' => '05554433221',
			'customer.email' => 'unit.test@example.com',
			'customer.telefax' => '05554433222',
			'customer.website' => 'www.example.com',
			'customer.mtime'=> '2010-01-05 00:00:05',
			'customer.ctime'=> '2010-01-01 00:00:00',
			'customer.editor' => 'unitTestUser',
			'typo3.pageid' => 99,
		);

		$this->object = new \Aimeos\MShop\Customer\Item\Typo3( $address, $values );
	}


	protected function tearDown()
	{
		unset( $this->object );
	}


	public function testGetPageId()
	{
		$this->assertEquals( 99, $this->object->getPageId() );
	}


	public function testSetPageId()
	{
		$this->object->setPageId( 321 );
		$this->assertTrue( $this->object->isModified() );
		$this->assertEquals( 321, $this->object->getPageId() );
	}


	public function testFromArray()
	{
		$address = new \Aimeos\MShop\Common\Item\Address\Standard( 'common.address.' );
		$item = new \Aimeos\MShop\Customer\Item\Typo3( $address );

		$list = array(
			'typo3.pageid' => 99,
		);

		$unknown = $item->fromArray( $list );

		$this->assertEquals( [], $unknown );
		$this->assertEquals( $list['typo3.pageid'], $item->getPageId() );
	}


	public function testToArray()
	{
		$arrayObject = $this->object->toArray( true );

		$this->assertEquals( $this->object->getPageId(), $arrayObject['typo3.pageid'] );
	}
}
