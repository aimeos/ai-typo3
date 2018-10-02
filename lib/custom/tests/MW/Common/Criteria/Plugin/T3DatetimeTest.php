<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014-2018
 */

namespace Aimeos\MW\Criteria\Plugin;


/**
 * Test class for \Aimeos\MW\Criteria\Plugin\T3Datetime
 */
class T3DatetimeTest extends \PHPUnit\Framework\TestCase
{
	private $object;


	/**
	 * Sets up the fixture. This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new \Aimeos\MW\Criteria\Plugin\T3Datetime();
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
		$this->assertEquals( 3661, $this->object->translate( '1970-01-01 01:01:01' ) );
	}


	public function testTranslateNull()
	{
		$this->assertEquals( 0, $this->object->translate( null ) );
	}


	public function testTranslateNegative()
	{
		$this->assertEquals( -1, $this->object->translate( '1969-12-31 23:59:59' ) );
	}


	public function testReverse()
	{
		$this->assertEquals( '1970-01-01 01:01:01', $this->object->reverse( 3661 ) );
	}


	public function testReverseZero()
	{
		$this->assertEquals( null, $this->object->reverse( 0 ) );
	}


	public function testReverseNegative()
	{
		$this->assertEquals( '1969-12-31 23:59:59', $this->object->reverse( -1 ) );
	}
}
