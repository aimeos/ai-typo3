<?php

/**
 * @copyright Copyright (c) Metaways Infosystems GmbH, 2013
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

/**
 * Test class for MW_Common_Criteria_Plugin_T3Datetime
 */
class MW_Common_Criteria_Plugin_T3DatetimeTest extends MW_Unittest_Testcase
{
	protected $_object;


	/**
	 * Runs the test methods of this class.
	 */
	public static function main()
	{
		require_once 'PHPUnit/TextUI/TestRunner.php';

		$suite  = new PHPUnit_Framework_TestSuite('MW_Common_Criteria_Plugin_T3DatetimeTest');
		PHPUnit_TextUI_TestRunner::run($suite);
	}


	/**
	 * Sets up the fixture. This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->_object = new MW_Common_Criteria_Plugin_T3Datetime();
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
		$this->assertEquals( 3661, $this->_object->translate( '1970-01-01 01:01:01' ) );
	}


	public function testTranslateNull()
	{
		$this->assertEquals( 0, $this->_object->translate( null ) );
	}


	public function testTranslateNegative()
	{
		$this->assertEquals( -1, $this->_object->translate( '1969-12-31 23:59:59' ) );
	}


	public function testReverse()
	{
		$this->assertEquals( '1970-01-01 01:01:01', $this->_object->reverse( 3661 ) );
	}


	public function testReverseZero()
	{
		$this->assertEquals( null, $this->_object->reverse( 0 ) );
	}


	public function testReverseNegative()
	{
		$this->assertEquals( '1969-12-31 23:59:59', $this->_object->reverse( -1 ) );
	}
}
