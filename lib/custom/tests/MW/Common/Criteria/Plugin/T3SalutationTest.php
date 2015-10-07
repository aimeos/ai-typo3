<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014
 */


namespace Aimeos\MW\Common\Criteria\Plugin;


/**
 * Test class for \Aimeos\MW\Common\Criteria\Plugin\T3Salutation
 */
class T3SalutationTest extends \PHPUnit_Framework_TestCase
{
	private $object;


	/**
	 * Sets up the fixture. This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new \Aimeos\MW\Common\Criteria\Plugin\T3Salutation();
	}


	/**
	 * Tears down the fixture. This method is called after a test is executed.
	 */
	protected function tearDown()
	{
		unset($this->object);
	}


	public function testTranslate()
	{
		$this->assertEquals( 99, $this->object->translate( \Aimeos\MShop\Common\Item\Address\Base::SALUTATION_UNKNOWN ) );
	}


	public function testTranslateCompany()
	{
		$this->assertEquals( 99, $this->object->translate( \Aimeos\MShop\Common\Item\Address\Base::SALUTATION_COMPANY ) );
	}


	public function testTranslateMale()
	{
		$this->assertEquals( 0, $this->object->translate( \Aimeos\MShop\Common\Item\Address\Base::SALUTATION_MR ) );
	}


	public function testTranslateFemale()
	{
		$this->assertEquals( 1, $this->object->translate( \Aimeos\MShop\Common\Item\Address\Base::SALUTATION_MRS ) );
		$this->assertEquals( 1, $this->object->translate( \Aimeos\MShop\Common\Item\Address\Base::SALUTATION_MISS ) );
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
}
