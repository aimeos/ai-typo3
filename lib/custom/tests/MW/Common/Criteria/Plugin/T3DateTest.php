<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014-2018
 */


namespace Aimeos\MW\Criteria\Plugin;


/**
 * Test class for \Aimeos\MW\Criteria\Plugin\T3Date
 */
class T3DateTest extends \PHPUnit\Framework\TestCase
{
	private $object;


	/**
	 * Sets up the fixture. This method is called before a test is executed.
	 */
	protected function setUp() : void
	{
		$this->object = new \Aimeos\MW\Criteria\Plugin\T3Date();
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
		$this->assertEquals( 86400, $this->object->translate( '1970-01-02' ) );
	}


	public function testTranslateNull()
	{
		$this->assertEquals( 0, $this->object->translate( null ) );
	}


	public function testTranslateNegative()
	{
		$this->assertEquals( -86400, $this->object->translate( '1969-12-31' ) );
	}


	public function testReverse()
	{
		$this->assertEquals( '1970-01-02', $this->object->reverse( 86400 ) );
	}


	public function testReverseZero()
	{
		$this->assertEquals( null, $this->object->reverse( 0 ) );
	}


	public function testReverseNegative()
	{
		$this->assertEquals( '1969-12-31', $this->object->reverse( -86400 ) );
	}
}
