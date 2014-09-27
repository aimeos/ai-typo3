<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014
 */


/**
 * Test class for MW_Common_Criteria_Plugin_T3Status
 */
class MW_Common_Criteria_Plugin_T3StatusTest extends MW_Unittest_Testcase
{
	private $_object;


	/**
	 * Sets up the fixture. This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->_object = new MW_Common_Criteria_Plugin_T3Status();
	}


	/**
	 * Tears down the fixture. This method is called after a test is executed.
	 */
	protected function tearDown()
	{
		unset($this->_object);
	}


	public function testTranslate()
	{
		$this->assertEquals( 0, $this->_object->translate( 1 ) );
	}


	public function testTranslateDisabled()
	{
		$this->assertEquals( 1, $this->_object->translate( 0 ) );
	}


	public function testReverse()
	{
		$this->assertEquals( 1, $this->_object->reverse( 0 ) );
	}


	public function testReverseDisabled()
	{
		$this->assertEquals( 0, $this->_object->reverse( 1 ) );
	}
}
