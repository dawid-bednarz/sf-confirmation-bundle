<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Model\Criteria;

use DateInterval;

class TokenCriteria
{
    protected $expiredInterval;
    protected $type;
    private $data;

    function __construct(DateInterval $expired, string $type, array $data=[])
    {
        $this->expiredInterval = $expired;
        $this->type = $type;
        $this->data = $data;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getExpiredInterval(): DateInterval
    {
        return $this->expiredInterval;
    }
}