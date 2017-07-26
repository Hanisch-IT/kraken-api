<?php

namespace HanischIt\KrakenApi\Model\AccountBalance;

use HanischIt\KrakenApi\Model\ResponseInterface;

/**
 * Class AccountBalanceResponse
 *
 * @package HanischIt\KrakenApi\Mod
 */
class AccountBalanceResponse implements ResponseInterface, AccountBalanceResponseInterface
{
    /**
     * @var AccountBalanceModel[]
     */
    private $balanceModels = [];

    /**
     * @param $result
     */
    public function manualMapping($result)
    {
        foreach ($result as $assetName => $balance) {
            $this->balanceModels[] = new AccountBalanceModel($assetName, $balance);
        }
    }

    /**
     * @return AccountBalanceModel[]
     */
    public function getBalanceModels()
    {
        return $this->balanceModels;
    }
}
