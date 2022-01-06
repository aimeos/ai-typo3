<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2021-2022
 */


namespace Aimeos\MW\Password;


class Typo3Test extends \PHPUnit\Framework\TestCase
{
	private $object;


	protected function setUp() : void
	{
		if( !class_exists( '\TYPO3\CMS\Core\Crypto\PasswordHashing\Md5PasswordHash' ) ) {
			$this->markTestSkipped( 'TYPO3 password hashing not available' );
		}

		$this->object = new \Aimeos\MW\Password\Typo3( new \TYPO3\CMS\Core\Crypto\PasswordHashing\Md5PasswordHash() );
	}


	protected function tearDown() : void
	{
		unset( $this->object );
	}


	public function testHash()
	{
		$this->assertStringStartsWith( '$1$', $this->object->hash( 'unittest' ) );
	}


	public function testVerify()
	{
		$this->assertTrue( $this->object->verify( 'unittest', $this->object->hash( 'unittest' ) ) );
	}
}
