<?php

namespace MBLSolutions\InspiredDeckSupport\Http\Controllers\Api\Report;

use Illuminate\Http\Request;
use MBLSolutions\InspiredDeck\ManageReport;

class ManageReportController
{
    /** @var ManageReport $report */
    protected $report;

    /**
     * Manage Report
     */
    public function __construct()
    {
        $this->report = new ManageReport;
    }

    /**
     * Show Report
     *
     * @param null $id
     * @return array
     */
    public function show($id = null): array
    {
        return $this->report->show($id);
    }

    /**
     * Create a New Report
     *
     * @param Request $request
     * @return array
     */
    public function store(Request $request): array
    {
        return $this->report->create($request->toArray());
    }

    /**
     * Create a New Report
     *
     * @param $id
     * @param Request $request
     * @return array
     */
    public function update($id, Request $request): array
    {
        return $this->report->update($id, $request->toArray());
    }

    /**
     * Delete a Report
     *
     * @param $id
     * @return array
     */
    public function destroy($id): array
    {
        return $this->report->delete($id);
    }

    /**
     * Test Report
     *
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function test($id, Request $request)
    {
        return $this->report->test($id, $request->toArray());
    }

    /**
     * Get Report Settings
     * e.g. connections, middleware, models, select_types
     *
     * @return array
     */
    public function settings(): array
    {
        return $this->report->settings();
    }

}
