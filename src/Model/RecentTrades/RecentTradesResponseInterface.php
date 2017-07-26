<?php
/**
 * Created by PhpStorm.
 * User: fabia
 * Date: 27.07.2017
 * Time: 00:17
 */

namespace HanischIt\KrakenApi\Model\RecentTrades;


/**
 * Class RecentTradesResponse
 *
 * @package HanischIt\KrakenApi\Model\AccountBalance
 */
interface RecentTradesResponseInterface
{
    /**
     * @param $result
     */
    public function manualMapping($result);

    /**
     * @param string $assetPair
     *
     * @return RecentTradeModel[]
     */
    public function getTradeModel($assetPair);

    /**
     * @return int
     */
    public function getLast();
}