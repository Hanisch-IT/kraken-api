<?php

namespace HanischIt\KrakenApi\Model\ServerTime;

use HanischIt\KrakenApi\Model\ResponseInterface;

/**
 * Class ServerTimeResponse
 * @package HanischIt\KrakenApi\Model\ServerTime
 */
class ServerTimeResponse implements ResponseInterface
{

    /**
     * as unix timestamp
     *
     * @var string
     */
    private $unixTime;

    /**
     * as RFC 1123 time format
     *
     * @var string
     */
    private $rfc1123;

    /**
     * @param string $unixTime
     */
    public function setUnixTime($unixTime)
    {
        $this->unixTime = $unixTime;
    }

    /**
     * @param string $rfc1123
     */
    public function setRfc1123($rfc1123)
    {
        $this->rfc1123 = $rfc1123;
    }


    /**
     * @return string
     */
    public function getUnixTime()
    {
        return $this->unixTime;
    }

    /**
     * @return string
     */
    public function getRfc1123()
    {
        return $this->rfc1123;
    }
}
