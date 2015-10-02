<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014
 */


/**
 * Test class for MW_Common_Criteria_Plugin_T3Date
 */
class MW_Common_Criteria_Plugin_T3DateTest extends MW_Unittest_Testcase
{
	private $object;


	/**
	 * Sets up the fixture. This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new MW_Common_Criteria_Plugin_T3Date();
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
