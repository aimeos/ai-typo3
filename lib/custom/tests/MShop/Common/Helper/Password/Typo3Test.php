<?php

namespace Aimeos\MShop\Common\Helper\Password;


/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2021
 */
class Typo3Test extends \PHPUnit\Framework\TestCase
{
	public function testException()
	{
		$this->expectException( '\\Aimeos\\MShop\\Exception' );
		new \Aimeos\MShop\Common\Helper\Password\Typo3( [] );
	}


	public function testEncodeNull()
	{
		$object = new \Aimeos\MShop\Common\Helper\Password\Typo3( array( 'object' => null ) );
		$this->assertEquals( 'unittest', $object->encode( 'unittest', 'salt' ) );
	}


	public function testEncodeObject()
	{
		$object = new \Aimeos\MShop\Common\Helper\Password\Typo3( array( 'object' => new TestPasswordHasherTypo3() ) );
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
