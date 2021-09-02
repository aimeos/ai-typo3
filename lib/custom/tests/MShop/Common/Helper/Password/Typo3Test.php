<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2021
 */


namespace Aimeos\MShop\Common\Helper\Password;


class Typo3Test extends \PHPUnit\Framework\TestCase
{
	public function testException()
	{
		$this->expectException( '\\Aimeos\\MShop\\Exception' );
		new \Aimeos\MShop\Common\Helper\Password\Typo3( [] );
	}


	public function testEncode()
	{
		$object = new \Aimeos\MShop\Common\Helper\Password\Typo3( ['object' => \TestHelper::getContext()->password()] );
		$this->assertStringStartsWith( '$2y$10$', $object->encode( 'unittest' ) );
	}
}
