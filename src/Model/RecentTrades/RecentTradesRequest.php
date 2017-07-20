<?php

namespace HanischIt\KrakenApi\Model\RecentTrades;

use HanischIt\KrakenApi\Enum\VisibilityEnum;
use HanischIt\KrakenApi\Model\RequestInterface;

/**
 * Class RecentTradesRequest
 *
 * @package HanischIt\Model\RecentTrades
 */
class RecentTradesRequest implements RequestInterface
{
    /**
     * @var
     */
    private $assetPair;
    /**
     * @var
     */
    private $since;

    /**
     * RecentTradesRequest constructor.
     *
     * @param string $assetPair
     * @param string $since
     */
    public function __construct($assetPair, $since)
    {
        $this->assetPair = $assetPair;
        $this->since = $since;
    }


    /**
     * Returns the api request name
     *
     * @return string
     */
    public function getMethod()
    {
        return 'Trades';
    }

    /**
     * @return string
     */
    public function getVisibility()
    {
        return VisibilityEnum::VISIBILITY_PUBLIC;
    }

    /**
     * @return array
     */
    public function getRequestData()
    {
        $ret = [];
        $ret['pair'] = $this->assetPair;
        if ($this->since) {
            $ret['since'] = $this->since;
        }

        return $ret;
    }

    /**
     * @return string
     */
    public function getResponseClassName()
    {
        return RecentTradesResponse::class;
    }
}
