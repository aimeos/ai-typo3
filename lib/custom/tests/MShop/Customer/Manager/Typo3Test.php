<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2014-2016
 */

namespace Aimeos\MShop\Customer\Manager;


class Typo3Test extends \PHPUnit_Framework_TestCase
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
		$search->setConditions( $search->compare( '==', 'customer.code', 'unitCustomer1@example.com' ) );
		$items = $this->object->searchItems( $search );

		if( ( $expected = reset( $items ) ) === false ) {
			throw new \RuntimeException( 'No customer found.' );
		}

		$actual = $this->object->getItem( $expected->getId() );
		$billing = $actual->getPaymentAddress();

		$this->assertEquals( $expected, $actual );

		$this->assertEquals( 'Max Mustermann', $actual->getLabel() );
		$this->assertEquals( 'unitCustomer1@example.com', $actual->getCode() );
		$this->assertEquals( 'mr', $billing->getSalutation() );
		$this->assertEquals( 'Example company LLC', $billing->getCompany() );
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
		$this->assertEquals( '01234567890', $billing->getTelephone() );
		$this->assertEquals( 'unitCustomer1@example.com', $billing->getEMail() );
		$this->assertEquals( '01234567890', $billing->getTelefax() );
		$this->assertEquals( 'www.example.com', $billing->getWebsite() );
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
		$search->setConditions( $search->compare( '==', 'customer.code', 'unitCustomer1@example.com' ) );
		$results = $this->object->searchItems( $search );

		if( ( $item = reset( $results ) ) === false ) {
			throw new \RuntimeException( 'No customer found.' );
		}

		$item->setId( null );
		$item->setCode( 'unitTest' );
		$item->setLabel( 'unitTest' );
		$item->setGroups( array( 1, 2, 3 ) );
		$this->object->saveItem( $item );
		$itemSaved = $this->object->getItem( $item->getId() );

		$itemExp = clone $itemSaved;
		$itemExp->setCode( 'unitTest2' );
		$itemExp->setLabel( 'unitTest2' );
		$itemExp->setGroups( array( 2, 4 ) );
		$this->object->saveItem( $itemExp );
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

		$this->setExpectedException( '\\Aimeos\\MShop\\Exception' );
		$this->object->getItem( $item->getId() );
	}


	public function testCreateSearch()
	{
		$this->assertInstanceOf( '\\Aimeos\\MW\\Criteria\\Iface', $this->object->createSearch() );
	}


	public function testSearchItems()
	{
		$search = $this->object->createSearch();

		$expr = array();
		$expr[] = $search->compare( '!=', 'customer.id', null );
		$expr[] = $search->compare( '==', 'customer.label', 'Franz-Xaver Gabler' );
		$expr[] = $search->compare( '==', 'customer.code', 'unitCustomer3@example.com' );
		$expr[] = $search->compare( '==', 'customer.salutation', 'mr' );
		$expr[] = $search->compare( '==', 'customer.company', 'Example company LLC' );
		$expr[] = $search->compare( '==', 'customer.title', '' );
		$expr[] = $search->compare( '==', 'customer.firstname', 'Franz-Xaver' );
		$expr[] = $search->compare( '==', 'customer.lastname', 'Gabler' );
		$expr[] = $search->compare( '==', 'customer.address1', 'Phantasiestraße 2' );
		$expr[] = $search->compare( '==', 'customer.postal', '23643' );
		$expr[] = $search->compare( '==', 'customer.city', 'Berlin' );
		$expr[] = $search->compare( '==', 'customer.state', 'Berlin' );
		$expr[] = $search->compare( '==', 'customer.telephone', '01234509876' );
		$expr[] = $search->compare( '==', 'customer.email', 'unitCustomer3@example.com' );
		$expr[] = $search->compare( '==', 'customer.telefax', '055544333212' );
		$expr[] = $search->compare( '==', 'customer.website', 'www.example.com' );
		$expr[] = $search->compare( '==', 'customer.longitude', '11.0' );
		$expr[] = $search->compare( '==', 'customer.latitude', '52.0' );
		$expr[] = $search->compare( '==', 'customer.status', 1 );
		$expr[] = $search->compare( '!=', 'customer.password', '' );
		$expr[] = $search->compare( '>', 'customer.mtime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '>', 'customer.ctime', '1970-01-01 00:00:00' );

		$expr[] = $search->compare( '!=', 'customer.address.id', null );
		$expr[] = $search->compare( '!=', 'customer.address.siteid', null );
		$expr[] = $search->compare( '!=', 'customer.address.parentid', null );
		$expr[] = $search->compare( '==', 'customer.address.salutation', 'company' );
		$expr[] = $search->compare( '==', 'customer.address.company', 'unitcompany' );
		$expr[] = $search->compare( '==', 'customer.address.title', 'unittitle' );
		$expr[] = $search->compare( '==', 'customer.address.firstname', 'unitfirstname' );
		$expr[] = $search->compare( '==', 'customer.address.lastname', 'unitlastname' );
		$expr[] = $search->compare( '==', 'customer.address.address1', 'unitaddress1' );
		$expr[] = $search->compare( '==', 'customer.address.address2', 'unitaddress2' );
		$expr[] = $search->compare( '==', 'customer.address.address3', 'unitaddress3' );
		$expr[] = $search->compare( '==', 'customer.address.postal', 'unitpostal' );
		$expr[] = $search->compare( '==', 'customer.address.city', 'unitcity' );
		$expr[] = $search->compare( '==', 'customer.address.state', 'unitstate' );
		$expr[] = $search->compare( '==', 'customer.address.countryid', 'DE' );
		$expr[] = $search->compare( '==', 'customer.address.languageid', 'de' );
		$expr[] = $search->compare( '==', 'customer.address.telephone', '1234567890' );
		$expr[] = $search->compare( '==', 'customer.address.email', 'unitCustomer3@example.com' );
		$expr[] = $search->compare( '==', 'customer.address.telefax', '1234567891' );
		$expr[] = $search->compare( '==', 'customer.address.website', 'unit.web.site' );
		$expr[] = $search->compare( '==', 'customer.address.longitude', '10.0' );
		$expr[] = $search->compare( '==', 'customer.address.latitude', '50.0' );
		$expr[] = $search->compare( '==', 'customer.address.flag', 0 );
		$expr[] = $search->compare( '==', 'customer.address.position', 2 );
		$expr[] = $search->compare( '==', 'customer.address.editor', $this->editor );
		$expr[] = $search->compare( '>', 'customer.address.mtime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '>', 'customer.address.ctime', '1970-01-01 00:00:00' );

		$expr[] = $search->compare( '!=', 'customer.lists.id', null );
		$expr[] = $search->compare( '!=', 'customer.lists.siteid', null );
		$expr[] = $search->compare( '!=', 'customer.lists.parentid', null );
		$expr[] = $search->compare( '==', 'customer.lists.domain', 'text' );
		$expr[] = $search->compare( '>', 'customer.lists.typeid', 0 );
		$expr[] = $search->compare( '>', 'customer.lists.refid', 0 );
		$expr[] = $search->compare( '==', 'customer.lists.datestart', '2010-01-01 00:00:00' );
		$expr[] = $search->compare( '==', 'customer.lists.dateend', '2022-01-01 00:00:00' );
		$expr[] = $search->compare( '>', 'customer.lists.position', 0 );
		$expr[] = $search->compare( '>=', 'customer.lists.mtime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '>=', 'customer.lists.ctime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '==', 'customer.lists.editor', $this->editor );

		$expr[] = $search->compare( '!=', 'customer.lists.type.id', null );
		$expr[] = $search->compare( '!=', 'customer.lists.type.siteid', null );
		$expr[] = $search->compare( '==', 'customer.lists.type.code', 'default' );
		$expr[] = $search->compare( '==', 'customer.lists.type.domain', 'text' );
		$expr[] = $search->compare( '==', 'customer.lists.type.label', 'Standard' );
		$expr[] = $search->compare( '==', 'customer.lists.type.status', 1 );
		$expr[] = $search->compare( '>=', 'customer.lists.type.mtime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '>=', 'customer.lists.type.ctime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '==', 'customer.lists.type.editor', $this->editor );

		$search->setConditions( $search->combine( '&&', $expr ) );
		$result = $this->object->searchItems( $search );

		$this->assertEquals( 1, count( $result ) );
		$this->assertEquals( array( 1, 2, 3 ), reset( $result )->getGroups() );
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
		$search->setConditions( $search->compare( '==', 'customer.code', 'unitCustomer1@example.com' ) );

		$results = $this->object->searchItems( $search, ['address', 'text'] );

		if( ( $item = reset( $results ) ) === false ) {
			throw new \Exception( 'No customer item for "unitCustomer1@example.com" available' );
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
