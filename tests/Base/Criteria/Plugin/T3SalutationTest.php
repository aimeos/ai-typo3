<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014-2025
 */


namespace Aimeos\Base\Criteria\Plugin;


/**
 * Test class for \Aimeos\Base\Criteria\Plugin\T3Salutation
 */
class T3SalutationTest extends \PHPUnit\Framework\TestCase
{
	private $object;


	/**
	 * Sets up the fixture. This method is called before a test is executed.
	 */
	protected function setUp() : void
	{
		$this->object = new \Aimeos\Base\Criteria\Plugin\T3Salutation();
	}


	/**
	 * Tears down the fixture. This method is called after a test is executed.
	 */
	protected function tearDown() : void
	{
		unset( $this->object );
	}


	public function testTranslate()
	{
		$this->assertEquals( 99, $this->object->translate( '' ) );
	}


	public function testTranslateMale()
	{
		$this->assertEquals( 0, $this->object->translate( 'mr' ) );
	}


	public function testTranslateFemale()
	{
		$this->assertEquals( 1, $this->object->translate( 'ms' ) );
	}


	public function testTranslateCompany()
	{
		$this->assertEquals( 10, $this->object->translate( 'company' ) );
	}


	public function testReverse()
	{
		$this->assertEquals( '', $this->object->reverse( 99 ) );
	}


	public function testReverseMale()
	{
		$this->assertEquals( 'mr', $this->object->reverse( 0 ) );
	}


	public function testReverseFemale()
	{
		$this->assertEquals( 'ms', $this->object->reverse( 1 ) );
	}


	public function testReverseCompany()
	{
		$this->assertEquals( 'company', $this->object->reverse( 10 ) );
	}
}
