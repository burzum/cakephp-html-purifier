<?php
namespace Burzum\HtmlPurifier\Test\TestCase\Lib;

use Burzum\HtmlPurifier\Lib\PurifierTrait;
use Cake\TestSuite\TestCase;

use Burzum\HtmlPurifier\Lib\Purifier;

class PurifierTraitTestClass {

    use PurifierTrait;
}

class PurifierTraitTest extends TestCase {

    /**
     * @var Burzum\HtmlPurifier\Test\TestCase\Lib\PurifierTraitTestClass
     */
    public $testClass;

    public function setUp()
    {
        parent::setUp();

        $this->testClass = new PurifierTraitTestClass();

        Purifier::config('default', [
            'HTML.AllowedElements' => 'a, em, blockquote, p, strong, pre, code, span,ul,ol,li,img',
            'HTML.AllowedAttributes' => 'a.href, a.title, img.src, img.alt, *.style',
            'CSS.AllowedProperties' => 'text-decoration',
            'HTML.TidyLevel' => 'heavy',
            'HTML.Doctype' => 'XHTML 1.0 Transitional'
        ]);
    }

    /**
     * testTraitMethods
     *
     * @return void
     */
    public function testTraitMethods()
    {
        $this->assertTrue(method_exists($this->testClass, 'purifyHtml'));
        $this->assertTrue(method_exists($this->testClass, 'getHtmlPurifier'));
    }

    /**
     * testPurifyHtml
     *
     * @return void
     */
    public function testPurifyHtml()
    {
        $html = '<p style="font-weight: bold;"><script>alert("alert!");</script><span style="text-decoration: line-through;" _mce_style="text-decoration: line-through;">shsfhshs</span></p><p><strong>sdhsdhds</strong></p><p><em>shsdh</em><span style="text-decoration: underline;" _mce_style="text-decoration: underline;">dsh</span></p><ul><li>sdgsgssgd</li><li>sdgdsg</li><li>sdgsdgsg</li><li>sdgdg<br></li></ul>';
        $html = $this->testClass->purifyHtml($html, 'default');
        $this->assertEquals($html, '<p><span style="text-decoration:line-through;">shsfhshs</span></p><p><strong>sdhsdhds</strong></p><p><em>shsdh</em><span style="text-decoration:underline;">dsh</span></p><ul><li>sdgsgssgd</li><li>sdgdsg</li><li>sdgsdgsg</li><li>sdgdg</li></ul>');
    }

    /**
     * testGetHtmlPurifier
     *
     * @return void
     */
    public function testGetHtmlPurifier()
    {
        $this->assertInstanceOf('HTMLPurifier', $this->testClass->getHtmlPurifier());
    }
}
