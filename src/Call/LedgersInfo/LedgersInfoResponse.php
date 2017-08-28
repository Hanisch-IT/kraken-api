<?php

namespace HanischIt\KrakenApi\Call\LedgersInfo;

use HanischIt\KrakenApi\Call\Shared\Model\LedgerInfoModel;
use HanischIt\KrakenApi\Model\ResponseInterface;

/**
 * Class LedgersInfoResponse
 * @package HanischIt\KrakenApi\Model\Trades
 */
class LedgersInfoResponse implements ResponseInterface
{
    /**
     * @var LedgerInfoModel[]
     */
    private $ledgerInfos;

    /**
     * @param array $result
     */
    public function manualMapping($result)
    {
        foreach ($result as $ledgerId => $ledger) {
            $this->ledgerInfos[] = new LedgerInfoModel(
                $ledgerId,
                $ledger['refid'],
                $ledger['time'],
                $ledger['type'],
                $ledger['aclass'],
                $ledger['asset'],
                $ledger['amount'],
                $ledger['fee'],
                $ledger['balance']
            );
        }
    }

    /**
     * @return LedgerInfoModel[]
     */
    public function getLedgerInfos()
    {
        return $this->ledgerInfos;
    }


}
