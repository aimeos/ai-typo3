<?php

namespace Aimeos\MShop\Common\Item\Helper\Password;


/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2016
 */
class Typo3Test extends \PHPUnit_Framework_TestCase
{
	public function testException()
	{
		$this->setExpectedException( '\\Aimeos\\MShop\\Exception' );
		new \Aimeos\MShop\Common\Item\Helper\Password\Typo3( [] );
	}


	public function testEncodeNull()
	{
		$object = new \Aimeos\MShop\Common\Item\Helper\Password\Typo3( array( 'object' => null ) );
		$this->assertEquals( 'unittest', $object->encode( 'unittest', 'salt' ) );
	}


	public function testEncodeObject()
	{
		$object = new \Aimeos\MShop\Common\Item\Helper\Password\Typo3( array( 'object' => new TestPasswordHasherTypo3() ) );
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