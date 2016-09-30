<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\ImageHandlerHelper;
use App\Test\TestCase\BaseIntegrationTestCase;
use Cake\View\View;
use Cake\ORM\TableRegistry;

/**
 * App\View\Helper\ImageHandlerHelper Test Case
 */
class ImageHandlerHelperTest extends BaseIntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.photos',
        'app.barcodes',
        'app.groups',
        'app.persons',
        'app.projects',
        'app.schools',
    ];
    
    /**
     * Test subject
     *
     * @var \App\View\Helper\ImageHandlerHelper
     */
    public $ImageHandler;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->ImageHandler = new ImageHandlerHelper($view);
        $this->Photos = TableRegistry::get('Photos');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ImageHandler);

        parent::tearDown();
    }

    public function testCreateProductPreview()
    {
        $photo = $this->Photos->get('59d395fa-e723-43f0-becb-0078425f9a27');
        $html = $this->ImageHandler->createProductPreview($photo);
        $this->assertEquals(
            '<img src="/photos/product/CombinationLayout1/59d395fa-e723-43f0-becb-0078425f9a27/200180" alt=""/>',
            $html
        );
    }
}
