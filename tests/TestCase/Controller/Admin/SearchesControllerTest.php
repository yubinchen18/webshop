<?php
namespace App\Test\TestCase\Controller\Admin;

use App\Controller\Admin\SearchesController;
use App\Test\TestCase\BaseIntegrationTestCase;

/**
 * App\Controller\SearchesController Test Case
 */
class SearchesControllerTest extends BaseIntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.addresses',
        'app.barcodes',
        'app.contacts',
        'app.groups',
        'app.persons',
        'app.projects',
        'app.schools',
        'app.users',
        'app.orders'
    ];
    
     public function setUp()
    {
        parent::setUp();
        $this->loginAdmin();
    }
    
    /**
     * Test showResults method
     *
     * @return void
     */
    public function testShowResultsEmptyQueryString()
    {
        //$searchTerm = '';
        $this->get('/admin/searches/showResults?query=');
        $this->assertResponseOk();
        $this->assertResponseContains('Voer een geldige zoekterm in.');
    }
    
    public function testShowResults()
    {
        $this->get('/admin/searches/showResults?query=3333GG');
        $this->assertResponseContains('Geen scholen gevonden');
        $this->assertResponseContains('Geen projecten gevonden');
        $this->assertResponseContains('Geen klassen gevonden');
        $this->assertResponseContains('Hoofdweg');
        $this->assertResponseOK();
    }
    
    
}
