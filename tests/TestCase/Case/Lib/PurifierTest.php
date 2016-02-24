<?php
/**
 * PurifierTest
 *
 * @author Florian Krämer
 * @copyright 2012 - 2016 Florian Krämer
 * @license MIT
 */
namespace Burzum\HtmlPurifier\Test\TestCase\Model\Behavior;

use Burzum\HtmlPurifier\Lib\Purifier;
use Cake\TestSuite\TestCase;

/**
 * PurifierTest
 */
class PurifierTest extends TestCase {

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [];

    /**
     * startTest
     *
     * @return void
     */
    public function setUp()
    {
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
     * testPurifyHtml
     *
     * @return void
     */
    public function testPurifyHtml()
    {
        $html = '<p style="font-weight: bold;"><script>alert("alert!");</script><span style="text-decoration: line-through;" _mce_style="text-decoration: line-through;">shsfhshs</span></p><p><strong>sdhsdhds</strong></p><p><em>shsdh</em><span style="text-decoration: underline;" _mce_style="text-decoration: underline;">dsh</span></p><ul><li>sdgsgssgd</li><li>sdgdsg</li><li>sdgsdgsg</li><li>sdgdg<br></li></ul>';
        $expected = '<p><span style="text-decoration:line-through;">shsfhshs</span></p><p><strong>sdhsdhds</strong></p><p><em>shsdh</em><span style="text-decoration:underline;">dsh</span></p><ul><li>sdgsgssgd</li><li>sdgdsg</li><li>sdgsdgsg</li><li>sdgdg</li></ul>';
        $result = Purifier::clean($html);
        $this->assertEquals($result, $expected);
    }

    /**
     * testGetHtmlPurifier
     *
     * @return void
     */
    public function testGetHtmlPurifier()
    {
        $result = Purifier::getPurifierInstance();
        $this->assertInstanceOf('HTMLPurifier', $result);
    }
}
