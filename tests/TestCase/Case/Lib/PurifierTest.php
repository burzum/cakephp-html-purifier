<?php
namespace Burzum\HtmlPurifier\Test\TestCase\Lib;

use Cake\TestSuite\TestCase;

use Burzum\HtmlPurifier\Lib\Purifier;

class PurifierTest extends TestCase {

	public function setUp() {
		parent::setUp();

		Purifier::config('default', [
			'HTML.AllowedElements' => 'a, em, blockquote, p, strong, pre, code, span,ul,ol,li,img',
			'HTML.AllowedAttributes' => 'a.href, a.title, img.src, img.alt, *.style',
			'CSS.AllowedProperties' => 'text-decoration',
			'HTML.TidyLevel' => 'heavy',
			'HTML.Doctype' => 'XHTML 1.0 Transitional'
		]);
	}

	/**
	 * getPurifierInstance
	 *
	 * @return void
	 */
	public function testConfig() {
		$this->assertInstanceOf('HTMLPurifier_Config', Purifier::config('default'));
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testConfigInvalidArgumentException() {
		Purifier::config('does-not-exist');
	}

	/**
	 * getPurifierInstance
	 *
	 * @return void
	 */
	public function testGetPurifierInstance() {
		$this->assertInstanceOf('HTMLPurifier', Purifier::getPurifierInstance('default'));
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testGetPurifierInstanceInvalidArgumentException() {
		Purifier::getPurifierInstance('does-not-exist');
	}
}