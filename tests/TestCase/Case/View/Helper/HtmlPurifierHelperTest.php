<?php
namespace Burzum\HtmlPurifier\Test\TestCase\View\Helper;

use Cake\Controller\Controller;
use Cake\TestSuite\TestCase;
use Cake\View\View;
use Burzum\HtmlPurifier\Lib\Purifier;
use Burzum\HtmlPurifier\View\Helper\HtmlPurifierHelper;

class HtmlHelperTest extends TestCase {

/**
 * Purifier property
 *
 * @var object
 */
    public $Purifier = null;

/**
 * setUp method
 *
 * @return void
 */
    public function setUp()
    {
        parent::setUp();
        $this->View = new View();
        $this->Purifier = new HtmlPurifierHelper($this->View);

        Purifier::config('default', [
            'HTML.AllowedElements' => 'a, em, blockquote, p, strong, pre, code, span,ul,ol,li,img',
            'HTML.AllowedAttributes' => 'a.href, a.title, img.src, img.alt, *.style',
            'CSS.AllowedProperties' => 'text-decoration',
            'HTML.TidyLevel' => 'heavy',
            'HTML.Doctype' => 'XHTML 1.0 Transitional'
        ]);
    }

/**
 * tearDown method
 *
 * @return void
 */
    public function tearDown()
    {
        parent::tearDown();
        unset($this->Purifier, $this->View);
    }

/**
 * testCleanSomeTinyMceOutput
 *
 * @return void
 */
    public function testCleanSomeTinyMceOutput()
    {
        $html = '<p style="font-weight: bold;"><script>alert("alert!");</script><span style="text-decoration: line-through;" _mce_style="text-decoration: line-through;">shsfhshs</span></p><p><strong>sdhsdhds</strong></p><p><em>shsdh</em><span style="text-decoration: underline;" _mce_style="text-decoration: underline;">dsh</span></p><ul><li>sdgsgssgd</li><li>sdgdsg</li><li>sdgsdgsg</li><li>sdgdg<br></li></ul>';
        $html = $this->Purifier->clean($html, 'default');
        $this->assertEquals($html, '<p><span style="text-decoration:line-through;">shsfhshs</span></p><p><strong>sdhsdhds</strong></p><p><em>shsdh</em><span style="text-decoration:underline;">dsh</span></p><ul><li>sdgsgssgd</li><li>sdgdsg</li><li>sdgsdgsg</li><li>sdgdg</li></ul>');
    }

}