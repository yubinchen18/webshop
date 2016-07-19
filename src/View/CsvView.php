<?php
namespace App\View;

use Cake\Core\Configure;
use Cake\Event\EventManager;
use Cake\Network\Request;
use Cake\Network\Response;

class CsvView extends AppView
{
    private $csv;

    /**
     * Constructor
     *
     * @param \Cake\Network\Request $request Request instance.
     * @param \Cake\Network\Response $response Response instance.
     * @param \Cake\Event\EventManager $eventManager EventManager instance.
     * @param array $viewOptions An array of view options
     */
    public function __construct(
        Request $request = null,
        Response $response = null,
        EventManager $eventManager = null,
        array $viewOptions = []
    ) {
        parent::__construct($request, $response, $eventManager, $viewOptions);

        if ($response && $response instanceof Response) {
            $response->type('csv');
        }

        $this->csv = fopen('php://temp', 'r+');
    }

    public function render($view = null, $layout = null)
    {
        $this->_header($this->viewVars['_headerCsv']);
        $this->_serialize($this->viewVars['_serialize']);

        rewind($this->csv);

        return stream_get_contents($this->csv);
    }

    protected function _header($header)
    {
        fputcsv($this->csv, $header);
    }

    protected function _map($row)
    {
        if (isset($this->viewVars['_csvMap']) && is_callable($this->viewVars['_csvMap'])) {
            $row = $this->viewVars['_csvMap']($row);
        }

        if (!is_array($row) && method_exists($row, 'toArray')) {
            $row = $row->toArray();
        }

        if (!is_array($row)) {
            throw new \Exception('Only arrays can be used in Csv');
        }

        return $row;
    }

    protected function _serialize($serialize)
    {
        if (is_array($serialize)) {
            throw new \Exception('Csv cannot handle multiple viewVars');
        }

        foreach ($this->viewVars[$serialize] as $row) {
            $mapped = $this->_map($row);

            fputcsv($this->csv, $mapped);
        }
    }
}