<?php

namespace MBLSolutions\InspiredDeckSupport\Http\Controllers\Api\Report;

use Illuminate\Http\Request;
use MBLSolutions\InspiredDeck\Report;

class ReportController
{

    /** @var Report $report */
    protected $report;

    /**
     * Report Controller
     */
    public function __construct()
    {
        $this->report = new Report;
    }

    /**
     * Get all the Reports
     *
     * @return array
     */
    public function index(): array
    {
        return $this->report->all();
    }

    /**
     * Show the Report
     *
     * @return array
     */
    public function show($id): array
    {
        return $this->report->show($id);
    }

    /**
     * Render the Report
     *
     * @param $id
     * @param Request $request
     * @return array
     */
    public function render($id, Request $request): array
    {
        return $this->report->render($id, $request->toArray());
    }

    /**
     * Get the Report Select Models
     *
     * @return array
     */
    public function models(): array
    {
        return $this->report->models();
    }

    /**
     * Get available report middleware
     *
     * @return array
     */
    public function middleware(): array
    {
        return $this->report->middleware();
    }

    /**
     * Get available report select types
     *
     * @return array
     */
    public function dataType(): array
    {
        return $this->report->dataType();
    }

    /**
     * Get the Report Select Connections
     *
     * @return array
     */
    public function connections(): array
    {
        return $this->report->connections();
    }

    /**
     * Get the report Print link
     *
     * @param $id
     * @param Request $request
     * @return array
     */
    public function print($id, Request $request): array
    {
        return $this->report->print($id, $request->all());
    }

    /**
     * Get the report export link
     *
     * @param $id
     * @param Request $request
     * @return array
     */
    public function export($id, Request $request): array
    {
        return $this->report->export($id, $request->all());
    }

}
