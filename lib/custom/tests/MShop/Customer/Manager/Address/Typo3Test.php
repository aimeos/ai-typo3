<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014-2018
 */

namespace Aimeos\MShop\Customer\Manager\Address;


class Typo3Test extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $editor = '';


	protected function setUp()
	{
		$this->editor = \TestHelper::getContext()->getEditor();
		$manager = \Aimeos\MShop\Customer\Manager\Factory::createManager( \TestHelper::getContext(), 'Typo3' );
		$this->object = $manager->getSubManager( 'address', 'Typo3' );
	}


	protected function tearDown()
	{
		unset( $this->object );
		\Aimeos\MShop::clear();
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
		$this->assertInstanceOf( '\\Aimeos\\MShop\\Common\\Item\\Address\\Iface', $item );
	}


	public function testGetItem()
	{
		$search = $this->object->createSearch();
		$search->setConditions( $search->compare( '==', 'customer.address.email', 'unitCustomer1@aimeos.org' ) );
		$items = $this->object->searchItems( $search );

		if( ( $expected = reset( $items ) ) === false ) {
			throw new \RuntimeException( 'No customer address found' );
		}

		$actual = $this->object->getItem( $expected->getId() );

		$this->assertEquals( $expected, $actual );

		$this->assertEquals( 'mr', $actual->getSalutation() );
		$this->assertEquals( 'ABC', $actual->getCompany() );
		$this->assertEquals( 'DE999999999', $actual->getVatID() );
		$this->assertEquals( 'Dr', $actual->getTitle() );
		$this->assertEquals( 'Our', $actual->getFirstname() );
		$this->assertEquals( 'Unittest', $actual->getLastname() );
		$this->assertEquals( 'Pickhuben', $actual->getAddress1() );
		$this->assertEquals( '2-4', $actual->getAddress2() );
		$this->assertEquals( '', $actual->getAddress3() );
		$this->assertEquals( '20457', $actual->getPostal() );
		$this->assertEquals( 'Hamburg', $actual->getCity() );
		$this->assertEquals( 'Hamburg', $actual->getState() );
		$this->assertEquals( 'de', $actual->getLanguageId() );
		$this->assertEquals( 'DE', $actual->getCountryId() );
		$this->assertEquals( '055544332211', $actual->getTelephone() );
		$this->assertEquals( 'unitCustomer1@aimeos.org', $actual->getEMail() );
		$this->assertEquals( '055544332212', $actual->getTelefax() );
		$this->assertEquals( 'unittest.aimeos.org', $actual->getWebsite() );
		$this->assertEquals( '10.0', $actual->getLongitude() );
		$this->assertEquals( '50.0', $actual->getLatitude() );
		$this->assertEquals( 0, $actual->getPosition() );
		$this->assertEquals( $this->editor, $actual->getEditor() );
	}


	public function testSaveUpdateDeleteItem()
	{
		$search = $this->object->createSearch();
		$search->setConditions( $search->compare( '==', 'customer.address.email', 'unitCustomer1@aimeos.org' ) );
		$results = $this->object->searchItems( $search );

		if( ( $item = reset( $results ) ) === false ) {
			throw new \RuntimeException( 'No customer address found' );
		}

		$item->setId( null );
		$resultSaved = $this->object->saveItem( $item );
		$itemSaved = $this->object->getItem( $item->getId() );

		$itemExp = clone $itemSaved;
		$itemExp->setCompany( 'unitTest' );
		$resultUpd = $this->object->saveItem( $itemExp );
		$itemUpd = $this->object->getItem( $itemExp->getId() );

		$this->object->deleteItem( $item->getId() );


		$this->assertTrue( $item->getId() !== null );
		$this->assertEquals( $item->getId(), $itemSaved->getId() );
		$this->assertEquals( $item->getSiteId(), $itemSaved->getSiteId() );
		$this->assertEquals( $item->getParentId(), $itemSaved->getParentId() );
		$this->assertEquals( $item->getSalutation(), $itemSaved->getSalutation() );
		$this->assertEquals( $item->getCompany(), $itemSaved->getCompany() );
		$this->assertEquals( $item->getVatID(), $itemSaved->getVatID() );
		$this->assertEquals( $item->getTitle(), $itemSaved->getTitle() );
		$this->assertEquals( $item->getFirstname(), $itemSaved->getFirstname() );
		$this->assertEquals( $item->getLastname(), $itemSaved->getLastname() );
		$this->assertEquals( $item->getAddress1(), $itemSaved->getAddress1() );
		$this->assertEquals( $item->getAddress2(), $itemSaved->getAddress2() );
		$this->assertEquals( $item->getAddress3(), $itemSaved->getAddress3() );
		$this->assertEquals( $item->getPostal(), $itemSaved->getPostal() );
		$this->assertEquals( $item->getCity(), $itemSaved->getCity() );
		$this->assertEquals( $item->getState(), $itemSaved->getState() );
		$this->assertEquals( $item->getLanguageId(), $itemSaved->getLanguageId() );
		$this->assertEquals( $item->getCountryId(), $itemSaved->getCountryId() );
		$this->assertEquals( $item->getTelephone(), $itemSaved->getTelephone() );
		$this->assertEquals( $item->getEMail(), $itemSaved->getEMail() );
		$this->assertEquals( $item->getTelefax(), $itemSaved->getTelefax() );
		$this->assertEquals( $item->getWebsite(), $itemSaved->getWebsite() );
		$this->assertEquals( $item->getLongitude(), $itemSaved->getLongitude() );
		$this->assertEquals( $item->getLatitude(), $itemSaved->getLatitude() );
		$this->assertEquals( $item->getPosition(), $itemSaved->getPosition() );
		$this->assertEquals( $item->getEditor(), $itemSaved->getEditor() );

		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeCreated() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeModified() );

		$this->assertEquals( $itemExp->getId(), $itemUpd->getId() );
		$this->assertEquals( $itemExp->getSiteId(), $itemUpd->getSiteId() );
		$this->assertEquals( $itemExp->getParentId(), $itemUpd->getParentId() );
		$this->assertEquals( $itemExp->getSalutation(), $itemUpd->getSalutation() );
		$this->assertEquals( $itemExp->getCompany(), $itemUpd->getCompany() );
		$this->assertEquals( $itemExp->getVatID(), $itemUpd->getVatID() );
		$this->assertEquals( $itemExp->getTitle(), $itemUpd->getTitle() );
		$this->assertEquals( $itemExp->getFirstname(), $itemUpd->getFirstname() );
		$this->assertEquals( $itemExp->getLastname(), $itemUpd->getLastname() );
		$this->assertEquals( $itemExp->getAddress1(), $itemUpd->getAddress1() );
		$this->assertEquals( $itemExp->getAddress2(), $itemUpd->getAddress2() );
		$this->assertEquals( $itemExp->getAddress3(), $itemUpd->getAddress3() );
		$this->assertEquals( $itemExp->getPostal(), $itemUpd->getPostal() );
		$this->assertEquals( $itemExp->getCity(), $itemUpd->getCity() );
		$this->assertEquals( $itemExp->getState(), $itemUpd->getState() );
		$this->assertEquals( $itemExp->getLanguageId(), $itemUpd->getLanguageId() );
		$this->assertEquals( $itemExp->getCountryId(), $itemUpd->getCountryId() );
		$this->assertEquals( $itemExp->getTelephone(), $itemUpd->getTelephone() );
		$this->assertEquals( $itemExp->getEMail(), $itemUpd->getEMail() );
		$this->assertEquals( $itemExp->getTelefax(), $itemUpd->getTelefax() );
		$this->assertEquals( $itemExp->getWebsite(), $itemUpd->getWebsite() );
		$this->assertEquals( $itemExp->getLongitude(), $itemUpd->getLongitude() );
		$this->assertEquals( $itemExp->getLatitude(), $itemUpd->getLatitude() );
		$this->assertEquals( $itemExp->getPosition(), $itemUpd->getPosition() );
		$this->assertEquals( $itemExp->getEditor(), $itemUpd->getEditor() );

		$this->assertEquals( $itemExp->getTimeCreated(), $itemUpd->getTimeCreated() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemUpd->getTimeModified() );

		$this->assertInstanceOf( \Aimeos\MShop\Common\Item\Iface::class, $resultSaved );
		$this->assertInstanceOf( \Aimeos\MShop\Common\Item\Iface::class, $resultUpd );

		$this->setExpectedException( '\\Aimeos\\MShop\\Exception' );
		$this->object->getItem( $item->getId() );
	}


	public function testCreateSearch()
	{
		$this->assertInstanceOf( '\\Aimeos\\MW\\Criteria\\Iface', $this->object->createSearch() );
	}


	public function testSearchItem()
	{
		$search = $this->object->createSearch();

		$expr = [];
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
		$expr[] = $search->compare( '>=', 'customer.address.longitude', '10.0' );
		$expr[] = $search->compare( '>=', 'customer.address.latitude', '50.0' );
		$expr[] = $search->compare( '==', 'customer.address.position', 1 );
		$expr[] = $search->compare( '!=', 'customer.address.mtime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '!=', 'customer.address.ctime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '==', 'customer.address.editor', $this->editor );

		$search->setConditions( $search->combine( '&&', $expr ) );
		$this->assertEquals( 1, count( $this->object->searchItems( $search ) ) );
	}


	public function testSearchItemTotal()
	{
		$total = 0;
		$search = $this->object->createSearch();

		$conditions = array(
			$search->compare( '~=', 'customer.address.company', 'ABC GmbH' ),
			$search->compare( '==', 'customer.address.editor', $this->editor )
		);

		$search->setConditions( $search->combine( '&&', $conditions ) );
		$search->setSlice( 0, 1 );

		$results = $this->object->searchItems( $search, [], $total );

		$this->assertEquals( 1, count( $results ) );
		$this->assertEquals( 2, $total );

		foreach( $results as $id => $item ) {
			$this->assertEquals( $id, $item->getId() );
		}
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
