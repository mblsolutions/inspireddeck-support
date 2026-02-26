<?php

namespace MBLSolutions\InspiredDeckSupport\Services;

use InspiredDeckAuth;

class UIAvatarsService
{
    /** @var string|null */
    public $name;

    /** @var bool */
    protected $bold = true;

    protected $fontSize = '0.5';

    protected $fontColor = '#ffffff';

    protected $bgColor = '#057BED';

    protected $size = 128;

    /** @var string */
    protected $endpoint = 'https://eu.ui-avatars.com/api/';

    /**
     * UIAvatarsService constructor.
     *
     * @param string|null $name
     */
    public function __construct(?string $name = null)
    {
        $this->name = $this->getAuthenticatedUsersName();
    }

    /**
     * Get the Users Avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->endpoint . '?' . $this->getQuery();
    }

    /**
     * Get the Query
     *
     * @return string
     */
    public function getQuery(): string
    {
        return http_build_query([
            'name' => $this->name,
            'bold' => $this->bold,
            'font-size' => $this->fontSize,
            'background' => $this->bgColor,
            'color' => $this->fontColor,
            'size' => $this->size
        ]);
    }

    /**
     * Get Authenticated Users Name
     *
     * @return string|null
     */
    public function getAuthenticatedUsersName(): ?string
    {
        return InspiredDeckAuth::getName();
    }

}
