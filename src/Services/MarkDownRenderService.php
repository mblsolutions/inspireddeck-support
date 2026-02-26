<?php

namespace MBLSolutions\InspiredDeckSupport\Services;

use Parsedown;

class MarkDownRenderService
{
    /** @var Parsedown  */
    public $driver;

    /**
     * Markdown Render Service
     *
     * @param Parsedown $driver
     */
    public function __construct(Parsedown $driver)
    {
        $this->driver = $driver;
    }

    /**
     * Render the Markdown
     *
     * @param string|null $content
     * @return string
     */
    public function render(?string $content = null): string
    {
        return $this->driver->text($content);
    }

}