<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014-2018
 */


namespace Aimeos\MW\Criteria\Plugin;


/**
 * Test class for \Aimeos\MW\Criteria\Plugin\T3Salutation
 */
class T3SalutationTest extends \PHPUnit\Framework\TestCase
{
	private $object;


	/**
	 * Sets up the fixture. This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new \Aimeos\MW\Criteria\Plugin\T3Salutation();
	}


	/**
	 * Tears down the fixture. This method is called after a test is executed.
	 */
	protected function tearDown()
	{
		unset( $this->object );
	}


	public function testTranslate()
	{
		$this->assertEquals( 99, $this->object->translate( \Aimeos\MShop\Common\Item\Address\Base::SALUTATION_UNKNOWN ) );
	}


	public function testTranslateMale()
	{
		$this->assertEquals( 0, $this->object->translate( \Aimeos\MShop\Common\Item\Address\Base::SALUTATION_MR ) );
	}


	public function testTranslateFemale()
	{
		$this->assertEquals( 1, $this->object->translate( \Aimeos\MShop\Common\Item\Address\Base::SALUTATION_MRS ) );
	}


	public function testTranslateFemale2()
	{
		$this->assertEquals( 2, $this->object->translate( \Aimeos\MShop\Common\Item\Address\Base::SALUTATION_MISS ) );
	}


	public function testTranslateCompany()
	{
		$this->assertEquals( 10, $this->object->translate( \Aimeos\MShop\Common\Item\Address\Base::SALUTATION_COMPANY ) );
	}


	public function testReverse()
	{
		$this->assertEquals( \Aimeos\MShop\Common\Item\Address\Base::SALUTATION_UNKNOWN, $this->object->reverse( 99 ) );
	}


	public function testReverseMale()
	{
		$this->assertEquals( \Aimeos\MShop\Common\Item\Address\Base::SALUTATION_MR, $this->object->reverse( 0 ) );
	}


	public function testReverseFemale()
	{
		$this->assertEquals( \Aimeos\MShop\Common\Item\Address\Base::SALUTATION_MRS, $this->object->reverse( 1 ) );
	}


	public function testReverseFemale2()
	{
		$this->assertEquals( \Aimeos\MShop\Common\Item\Address\Base::SALUTATION_MISS, $this->object->reverse( 2 ) );
	}


	public function testReverseCompany()
	{
		$this->assertEquals( \Aimeos\MShop\Common\Item\Address\Base::SALUTATION_COMPANY, $this->object->reverse( 10 ) );
	}
}
