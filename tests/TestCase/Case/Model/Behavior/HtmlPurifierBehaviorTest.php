<?php
/**
 * Upload Validator Behavior Test
 *
 * @author Florian Krämer
 * @copyright 2012 - 2015 Florian Krämer
 * @license MIT
 */
namespace Burzum\HtmlPurifier\Test\TestCase\Model\Behavior;

use Burzum\HtmlPurifier\Lib\Purifier;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\ORM\Table;
use Cake\Core\Plugin;
use Cake\TestSuite\TestCase;

/**
 * VoidUploadModel
 */
class VoidModel extends Table {

	/**
	 * name property
	 *
	 * @var string 'TheVoid'
	 */
	public $name = 'VoidModel';

	/**
	 * useTable property
	 *
	 * @var bool false
	 */
	public $useTable = false;

	/**
	 * Initialize
	 *
	 * @param array $config
	 * @return void
	 */
		public function initialize(array $config) {
			parent::initialize($config);
			$this->addBehavior('Burzum/HtmlPurifier.HtmlPurifier', [
				'fields' => ['field1']
			]);
		}
}

/**
 * HtmlPurifierBehaviorTest
 */
class HtmlPurifierBehaviorTest extends TestCase {

/**
 * Holds the instance of the table
 *
 * @var mixed
 */
	public $Article = null;

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
	public function setUp() {
		parent::setUp();

		Purifier::config('default', [
			'HTML.AllowedElements' => 'a, em, blockquote, p, strong, pre, code, span,ul,ol,li,img',
			'HTML.AllowedAttributes' => 'a.href, a.title, img.src, img.alt, *.style',
			'CSS.AllowedProperties' => 'text-decoration',
			'HTML.TidyLevel' => 'heavy',
			'HTML.Doctype' => 'XHTML 1.0 Transitional'
		]);

		$this->table = new VoidModel();
	}

/**
 * endTest
 *
 * @return void
 */
	public function tearDown() {
		unset($this->table);
	}

/**
 * configureUploadValidation
 *
 * @return void
 */
	public function testBeforeMarshal() {
		$html = '<p style="font-weight: bold;"><script>alert("alert!");</script><span style="text-decoration: line-through;" _mce_style="text-decoration: line-through;">shsfhshs</span></p><p><strong>sdhsdhds</strong></p><p><em>shsdh</em><span style="text-decoration: underline;" _mce_style="text-decoration: underline;">dsh</span></p><ul><li>sdgsgssgd</li><li>sdgdsg</li><li>sdgsdgsg</li><li>sdgdg<br></li></ul>';
		$expected = '<p><span style="text-decoration:line-through;">shsfhshs</span></p><p><strong>sdhsdhds</strong></p><p><em>shsdh</em><span style="text-decoration:underline;">dsh</span></p><ul><li>sdgsgssgd</li><li>sdgdsg</li><li>sdgsdgsg</li><li>sdgdg</li></ul>';
		$event = new Event('Model.beforeMarshal');
		$data = new \ArrayObject([
			'field1' => $html,
			'field2' => '<b>Don\'t change me!</b>'
		]);
		$options = new \ArrayObject();
		$this->table->behaviors()->HtmlPurifier->beforeMarshal($event, $data, $options);
		$this->assertEquals($data['field1'], $expected);
		$this->assertEquals($data['field2'], '<b>Don\'t change me!</b>');
	}
}
