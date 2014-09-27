<?php

/**
 * @copyright Copyright (c) Metaways Infosystems GmbH, 2011
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */


/**
 * Test class for MW_Session_Typo3.
 */
class MW_Session_Typo3Test extends MW_Unittest_Testcase
{
	private $_object;


	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @access protected
	 */
	protected function setUp()
	{
		$mock = new Tslib_FeUserAuth();
		$this->_object = new MW_Session_Typo3($mock);
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @access protected
	 */
	protected function tearDown()
	{
		unset($this->_object);
	}

	public function testGet()
	{
		$this->assertEquals('', $this->_object->get('test'));

		$this->_object->set('test', '123456789');
		$this->assertEquals('123456789', $this->_object->get('test'));
	}

	public function testSet()
	{
		$this->_object->set('test', '123');
		$this->assertEquals( '123', $this->_object->get( 'test' ) );

		$this->_object->set('test', '234');
		$this->assertEquals( '234', $this->_object->get( 'test' ) );
	}
}



class Tslib_FeUserAuth
{
	private $_session = array();

	/**
	 * @param string $type
	 * @param string $key
	 */
	public function getKey( $type , $key )
	{
		if ( isset($this->_session[$key]) ) {
			return $this->_session[$key];
		}
	}

	/**
	 * @param string $type
	 * @param string $key
	 */
	public function setKey( $type , $key , $data )
	{
		$this->_session[$key] = $data;
	}

	public function storeSessionData()
	{
	}
}
