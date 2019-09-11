<?php

namespace MBLSolutions\InspiredDeckSupport\Http\Controllers\Async\Metric;

use MBLSolutions\InspiredDeck\Metric;

class DashboardController
{

    /**
     * Get Dashboard Metrics
     *
     * @return array
     */
    public function index(): array
    {
        return (new Metric())->dashboard();
    }

}