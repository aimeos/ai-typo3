<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2014-2018
 */

namespace Aimeos\MShop\Customer\Manager;


class Typo3Test extends \PHPUnit\Framework\TestCase
{
	private $context;
	private $object;
	private $editor;
	private $item;


	protected function setUp()
	{
		$this->context = \TestHelper::getContext();
		$this->editor = $this->context->getEditor();
		$this->context->getConfig()->set( 'mshop/customer/manager/typo3/pid-default', 999999 );
		$this->object = new \Aimeos\MShop\Customer\Manager\Typo3( $this->context );
	}


	protected function tearDown()
	{
		unset( $this->object, $this->item );
	}


	public function testGetSearchAttributes()
	{
		foreach( $this->object->getSearchAttributes() as $attribute )
		{
			$this->assertInstanceOf( '\\Aimeos\\MW\\Criteria\\Attribute\\Iface', $attribute );
		}
	}


	public function testCreateItem()
	{
		$item = $this->object->createItem();
		$this->assertInstanceOf( '\\Aimeos\\MShop\\Customer\\Item\\Iface', $item );
		$this->assertInstanceOf( '\\Aimeos\\MShop\\Customer\\Item\\Typo3', $item );
		$this->assertEquals( 999999, $item->getPageId() );
	}


	public function testGetItem()
	{
		$search = $this->object->createSearch();
		$search->setConditions( $search->compare( '==', 'customer.code', 'UTC001' ) );
		$items = $this->object->searchItems( $search );

		if( ( $expected = reset( $items ) ) === false ) {
			throw new \RuntimeException( 'No customer found.' );
		}

		$actual = $this->object->getItem( $expected->getId() );
		$billing = $actual->getPaymentAddress();

		$this->assertEquals( $expected, $actual );

		$this->assertEquals( 'unitCustomer1', $actual->getLabel() );
		$this->assertEquals( 'UTC001', $actual->getCode() );
		$this->assertEquals( 'mr', $billing->getSalutation() );
		$this->assertEquals( 'ABC GmbH', $billing->getCompany() );
		$this->assertEquals( 'Dr.', $billing->getTitle() );
		$this->assertEquals( 'Max', $billing->getFirstname() );
		$this->assertEquals( 'Mustermann', $billing->getLastname() );
		$this->assertEquals( 'Musterstraße 1a', $billing->getAddress1() );
		$this->assertEquals( '', $billing->getAddress2() );
		$this->assertEquals( '', $billing->getAddress3() );
		$this->assertEquals( '20001', $billing->getPostal() );
		$this->assertEquals( 'Musterstadt', $billing->getCity() );
		$this->assertEquals( 'Hamburg', $billing->getState() );
		$this->assertEquals( 'de', $billing->getLanguageId() );
		$this->assertEquals( 'DE', $billing->getCountryId() );
		$this->assertEquals( '055544332211', $billing->getTelephone() );
		$this->assertEquals( 'unitCustomer1@aimeos.org', $billing->getEMail() );
		$this->assertEquals( '055544332212', $billing->getTelefax() );
		$this->assertEquals( 'unittest.aimeos.org', $billing->getWebsite() );
		$this->assertEquals( '10.0', $billing->getLongitude() );
		$this->assertEquals( '50.0', $billing->getLatitude() );
		$this->assertEquals( 1, $actual->getStatus() );
		$this->assertEquals( '5f4dcc3b5aa765d61d8327deb882cf99', $actual->getPassword() );
		$this->assertEquals( '2011-01-13 11:03:36', $actual->getTimeCreated() );
		$this->assertEquals( '2011-01-13 11:03:46', $actual->getTimeModified() );
		$this->assertEquals( '', $actual->getEditor() );
	}


	public function testSaveUpdateDeleteItem()
	{
		$search = $this->object->createSearch();
		$search->setConditions( $search->compare( '==', 'customer.code', 'UTC001' ) );
		$results = $this->object->searchItems( $search );

		if( ( $item = reset( $results ) ) === false ) {
			throw new \RuntimeException( 'No customer found.' );
		}

		$item->setId( null );
		$item->setCode( 'unitTest' );
		$item->setLabel( 'unitTest' );
		$item->setGroups( array( 1, 2, 3 ) );
		$resultSaved = $this->object->saveItem( $item );
		$itemSaved = $this->object->getItem( $item->getId() );

		$itemExp = clone $itemSaved;
		$itemExp->setCode( 'unitTest2' );
		$itemExp->setLabel( 'unitTest2' );
		$itemExp->setGroups( array( 2, 4 ) );
		$resultUpd = $this->object->saveItem( $itemExp );
		$itemUpd = $this->object->getItem( $itemExp->getId() );

		$this->object->deleteItem( $item->getId() );


		$this->assertTrue( $item->getId() !== null );
		$this->assertEquals( $item->getId(), $itemSaved->getId() );
		$this->assertEquals( $item->getSiteId(), $itemSaved->getSiteId() );
		$this->assertEquals( $item->getStatus(), $itemSaved->getStatus() );
		$this->assertEquals( $item->getCode(), $itemSaved->getCode() );
		$this->assertEquals( $item->getLabel(), $itemSaved->getLabel() );
		$this->assertEquals( $item->getPaymentAddress(), $itemSaved->getPaymentAddress() );
		$this->assertEquals( $item->getBirthday(), $itemSaved->getBirthday() );
		$this->assertEquals( $item->getPassword(), $itemSaved->getPassword() );
		$this->assertEquals( $item->getGroups(), $itemSaved->getGroups() );
		$this->assertEquals( $item->getPageId(), $itemSaved->getPageId() );

		$this->assertEquals( '', $itemSaved->getEditor() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeCreated() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeModified() );

		$this->assertEquals( $itemExp->getId(), $itemUpd->getId() );
		$this->assertEquals( $itemExp->getSiteId(), $itemUpd->getSiteId() );
		$this->assertEquals( $itemExp->getStatus(), $itemUpd->getStatus() );
		$this->assertEquals( $itemExp->getCode(), $itemUpd->getCode() );
		$this->assertEquals( $itemExp->getLabel(), $itemUpd->getLabel() );
		$this->assertEquals( $itemExp->getPaymentAddress(), $itemUpd->getPaymentAddress() );
		$this->assertEquals( $itemExp->getBirthday(), $itemUpd->getBirthday() );
		$this->assertEquals( $itemExp->getPassword(), $itemUpd->getPassword() );
		$this->assertEquals( $itemExp->getGroups(), $itemUpd->getGroups() );
		$this->assertEquals( $itemExp->getPageId(), $itemUpd->getPageId() );

		$this->assertEquals( '', $itemUpd->getEditor() );
		$this->assertEquals( $itemExp->getTimeCreated(), $itemUpd->getTimeCreated() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemUpd->getTimeModified() );

		$this->assertInstanceOf( '\Aimeos\MShop\Common\Item\Iface', $resultSaved );
		$this->assertInstanceOf( '\Aimeos\MShop\Common\Item\Iface', $resultUpd );

		$this->setExpectedException( '\\Aimeos\\MShop\\Exception' );
		$this->object->getItem( $item->getId() );
	}


	public function testGetSaveAddressItems()
	{
		$item = $this->object->findItem( 'UTC001', ['customer/address'] );

		$item->setId( null )->setCode( 'xyz' );
		$item->getPaymentAddress()->setEmail( 'unittest@xyz.com' );
		$item->addAddressItem( new \Aimeos\MShop\Common\Item\Address\Standard( 'customer.address.' ) );
		$this->object->saveItem( $item );

		$item2 = $this->object->findItem( 'xyz', ['customer/address'] );

		$this->object->deleteItem( $item->getId() );

		$this->assertEquals( 2, count( $item->getAddressItems() ) );
		$this->assertEquals( 2, count( $item2->getAddressItems() ) );
	}


	public function testGetSavePropertyItems()
	{
		$item = $this->object->findItem( 'UTC001', ['customer/property'] );

		$item->setId( null )->setCode( 'xyz' );
		$item->getPaymentAddress()->setEmail( 'unittest@xyz.com' );
		$this->object->saveItem( $item );

		$item2 = $this->object->findItem( 'xyz', ['customer/property'] );

		$this->object->deleteItem( $item->getId() );

		$this->assertEquals( 1, count( $item->getPropertyItems() ) );
		$this->assertEquals( 1, count( $item2->getPropertyItems() ) );
	}


	public function testCreateSearch()
	{
		$this->assertInstanceOf( '\\Aimeos\\MW\\Criteria\\Iface', $this->object->createSearch() );
	}


	public function testSearchItems()
	{
		$total = 0;
		$search = $this->object->createSearch();

		$expr = [];
		$expr[] = $search->compare( '!=', 'customer.id', null );
		$expr[] = $search->compare( '==', 'customer.label', 'unitCustomer2' );
		$expr[] = $search->compare( '==', 'customer.code', 'UTC002' );

		$expr[] = $search->compare( '==', 'customer.salutation', 'mrs' );
		$expr[] = $search->compare( '>=', 'customer.company', '' );
		$expr[] = $search->compare( '>=', 'customer.vatid', '' );
		$expr[] = $search->compare( '>=', 'customer.title', '' );
		$expr[] = $search->compare( '>=', 'customer.firstname', '' );
		$expr[] = $search->compare( '>=', 'customer.lastname', '' );
		$expr[] = $search->compare( '>=', 'customer.address1', '' );
		$expr[] = $search->compare( '>=', 'customer.address2', '' );
		$expr[] = $search->compare( '>=', 'customer.address3', '' );
		$expr[] = $search->compare( '>=', 'customer.postal', '' );
		$expr[] = $search->compare( '>=', 'customer.city', '' );
		$expr[] = $search->compare( '>=', 'customer.state', '' );
		$expr[] = $search->compare( '!=', 'customer.languageid', null );
		$expr[] = $search->compare( '>=', 'customer.countryid', '' );
		$expr[] = $search->compare( '>=', 'customer.telephone', '' );
		$expr[] = $search->compare( '>=', 'customer.email', '' );
		$expr[] = $search->compare( '>=', 'customer.telefax', '' );
		$expr[] = $search->compare( '>=', 'customer.website', '' );
		$expr[] = $search->compare( '>=', 'customer.longitude', '10.0' );
		$expr[] = $search->compare( '>=', 'customer.latitude', '50.0' );

		$expr[] = $search->compare( '==', 'customer.birthday', '1970-01-01' );
		$expr[] = $search->compare( '>=', 'customer.password', '' );
		$expr[] = $search->compare( '==', 'customer.status', 0 );
		$expr[] = $search->compare( '!=', 'customer.mtime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '!=', 'customer.ctime', '1970-01-01 00:00:00' );

		$expr[] = $search->compare( '!=', 'customer.address.id', null );
		$expr[] = $search->compare( '!=', 'customer.address.parentid', null );
		$expr[] = $search->compare( '==', 'customer.address.company', 'ABC GmbH' );
		$expr[] = $search->compare( '==', 'customer.address.vatid', 'DE999999999' );
		$expr[] = $search->compare( '==', 'customer.address.salutation', 'mr' );
		$expr[] = $search->compare( '==', 'customer.address.title', 'Dr.' );
		$expr[] = $search->compare( '==', 'customer.address.firstname', 'Good' );
		$expr[] = $search->compare( '==', 'customer.address.lastname', 'Unittest' );
		$expr[] = $search->compare( '==', 'customer.address.address1', 'Pickhuben' );
		$expr[] = $search->compare( '==', 'customer.address.address2', '2-4' );
		$expr[] = $search->compare( '==', 'customer.address.address3', '' );
		$expr[] = $search->compare( '==', 'customer.address.postal', '11099' );
		$expr[] = $search->compare( '==', 'customer.address.city', 'Berlin' );
		$expr[] = $search->compare( '==', 'customer.address.state', 'Berlin' );
		$expr[] = $search->compare( '==', 'customer.address.languageid', 'de' );
		$expr[] = $search->compare( '==', 'customer.address.countryid', 'DE' );
		$expr[] = $search->compare( '==', 'customer.address.telephone', '055544332221' );
		$expr[] = $search->compare( '==', 'customer.address.email', 'unitCustomer2@aimeos.org' );
		$expr[] = $search->compare( '==', 'customer.address.telefax', '055544333212' );
		$expr[] = $search->compare( '==', 'customer.address.website', 'unittest.aimeos.org' );
		$expr[] = $search->compare( '>=', 'customer.address.longitude', '11.0' );
		$expr[] = $search->compare( '>=', 'customer.address.latitude', '52.0' );
		$expr[] = $search->compare( '==', 'customer.address.position', 1 );
		$expr[] = $search->compare( '!=', 'customer.address.mtime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '!=', 'customer.address.ctime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '==', 'customer.address.editor', $this->editor );

		$search->setConditions( $search->combine( '&&', $expr ) );
		$result = $this->object->searchItems( $search, [], $total );

		$this->assertEquals( 1, count( $result ) );
		$this->assertEquals( [1], reset( $result )->getGroups() );
	}


	public function testSearchItemsTotal()
	{
		$search = $this->object->createSearch();
		$search->setSlice( 0, 2 );

		$total = 0;
		$results = $this->object->searchItems( $search, [], $total );

		$this->assertEquals( 2, count( $results ) );
		$this->assertEquals( 3, $total );
	}


	public function testSearchItemsCriteria()
	{
		$search = $this->object->createSearch( true );
		$results = $this->object->searchItems( $search );

		$this->assertEquals( 2, count( $results ) );

		foreach( $results as $itemId => $item ) {
			$this->assertEquals( $itemId, $item->getId() );
		}
	}


	public function testSearchItemsRef()
	{
		$search = $this->object->createSearch();
		$search->setConditions( $search->compare( '==', 'customer.code', 'UTC001' ) );

		$results = $this->object->searchItems( $search, ['customer/address', 'text'] );

		if( ( $item = reset( $results ) ) === false ) {
			throw new \Exception( 'No customer item for "UTC001" available' );
		}

		$this->assertEquals( 1, count( $item->getRefItems( 'text' ) ) );
		$this->assertEquals( 1, count( $item->getAddressItems() ) );
	}


	public function testGetSubManager()
	{
		$this->setExpectedException( '\\Aimeos\\MShop\\Exception' );
		$this->object->getSubManager( 'unknown' );
	}


	public function testGetSubManagerInvalidName()
	{
		$this->setExpectedException( '\\Aimeos\\MShop\\Exception' );
		$this->object->getSubManager( 'address', 'unknown' );
	}
}
