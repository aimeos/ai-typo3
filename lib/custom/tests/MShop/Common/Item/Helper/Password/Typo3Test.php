<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */


class MShop_Common_Item_Helper_Password_Typo3Test extends PHPUnit_Framework_TestCase
{
	public function testException()
	{
		$this->setExpectedException( 'MShop_Exception' );
		new MShop_Common_Item_Helper_Password_Typo3( array() );
	}


	public function testEncodeNull()
	{
		$object = new MShop_Common_Item_Helper_Password_Typo3( array( 'object' => null ) );
		$this->assertEquals( 'unittest', $object->encode( 'unittest', 'salt' ) );
	}


	public function testEncodeObject()
	{
		$object = new MShop_Common_Item_Helper_Password_Typo3( array( 'object' => new TestPasswordHasherTypo3() ) );
		$this->assertEquals( 'abcd', $object->encode( 'unittest', 'salt' ) );
	}
}


class TestPasswordHasherTypo3
{
	public function getHashedPassword( $password, $salt )
	{
		return 'abcd';
	}
}