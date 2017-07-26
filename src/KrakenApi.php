<?php
/**
 * @author  Fabian Hanisch
 * @since   16.07.2017 02:56
 * @version 1.0
 */

namespace HanischIt\KrakenApi;

use HanischIt\KrakenApi\External\HttpClient;
use HanischIt\KrakenApi\Model\AccountBalance\AccountBalanceRequest;
use HanischIt\KrakenApi\Model\AccountBalance\AccountBalanceResponse;
use HanischIt\KrakenApi\Model\AddOrder\AddOrderRequest;
use HanischIt\KrakenApi\Model\AddOrder\AddOrderResponse;
use HanischIt\KrakenApi\Model\Assets\AssetsRequest;
use HanischIt\KrakenApi\Model\Assets\AssetsResponse;
use HanischIt\KrakenApi\Model\ClosedOrders\ClosedOrdersRequest;
use HanischIt\KrakenApi\Model\ClosedOrders\ClosedOrdersResponse;
use HanischIt\KrakenApi\Model\GetTicker\TickerRequest;
use HanischIt\KrakenApi\Model\GetTicker\TickerResponse;
use HanischIt\KrakenApi\Model\Header;
use HanischIt\KrakenApi\Model\OpenOrders\OpenOrdersRequest;
use HanischIt\KrakenApi\Model\OpenOrders\OpenOrdersResponse;
use HanischIt\KrakenApi\Model\OrderBook\OrderBookRequest;
use HanischIt\KrakenApi\Model\OrderBook\OrderBookResponse;
use HanischIt\KrakenApi\Model\RecentTrades\RecentTradesRequest;
use HanischIt\KrakenApi\Model\RecentTrades\RecentTradesResponse;
use HanischIt\KrakenApi\Model\RequestInterface;
use HanischIt\KrakenApi\Model\RequestOptions;
use HanischIt\KrakenApi\Model\ResponseInterface;
use HanischIt\KrakenApi\Model\ServerTime\ServerTimeRequest;
use HanischIt\KrakenApi\Model\ServerTime\ServerTimeResponse;
use HanischIt\KrakenApi\Model\SpreadData\SpreadDataRequest;
use HanischIt\KrakenApi\Model\SpreadData\SpreadDataResponse;
use HanischIt\KrakenApi\Model\TradableAssetPairs\TradableAssetPairsRequest;
use HanischIt\KrakenApi\Model\TradableAssetPairs\TradableAssetPairsResponse;
use HanischIt\KrakenApi\Service\RequestService\GetRequest;
use HanischIt\KrakenApi\Service\RequestService\Nonce;
use HanischIt\KrakenApi\Service\RequestService\PostRequest;
use HanischIt\KrakenApi\Service\RequestService\Request;
use HanischIt\KrakenApi\Service\RequestService\RequestHeader;

/**
 * Class KrakenApi
 *
 * @package HanischIt\KrakenApi
 */
class KrakenApi
{
    /**
     * @var RequestOptions
     */
    private $requestOptions;
    /**
     * @var Header
     */
    private $header;
    /**
     * @var Request
     */
    private $request;

    /**
     * KrakenApi constructor.
     *
     * @param string $apiKey
     * @param string $apiSign
     * @param string $version
     * @param string $endpoint
     */
    public function __construct($apiKey, $apiSign, $version = '0', $endpoint = 'https://api.kraken.com/')
    {
        $httpClient = new HttpClient(['verify' => false]);
        $requestHeader = new RequestHeader();
        $nonce = new Nonce();

        $this->requestOptions = new RequestOptions($endpoint, $version);
        $postRequest = new PostRequest($httpClient, $requestHeader, $nonce);
        $getRequest = new GetRequest($httpClient, $requestHeader);
        $this->request = new Request($postRequest, $getRequest);
        $this->header = new Header($apiKey, $apiSign);
    }

    /**
     * @return ServerTimeResponse|ResponseInterface
     */
    public function getServerTime()
    {
        $serverTimeRequest = new ServerTimeRequest();

        return $this->doRequest($serverTimeRequest);
    }

    /**
     * @return AccountBalanceResponse|ResponseInterface
     */
    public function getAccountBalance()
    {
        $accountBalanceRequest = new AccountBalanceRequest();

        return $this->doRequest($accountBalanceRequest);
    }

    /**
     * @param string $pair
     * @param string $type
     * @param string $orderType
     * @param null|float $price
     * @param null|float $volume
     *
     * @return ResponseInterface|AddOrderResponse
     */
    public function addOrder($pair, $type, $orderType, $price = null, $volume = null)
    {
        $addOrderRequest = new AddOrderRequest($pair, $type, $orderType, $price, $volume);

        return $this->doRequest($addOrderRequest);
    }

    /**
     * @return ResponseInterface|AssetsResponse
     */
    public function getAssets()
    {
        $assetsRequest = new AssetsRequest();

        return $this->doRequest($assetsRequest);
    }

    /**
     * @param array $assetNames
     *
     * @return ResponseInterface|TickerResponse
     */
    public function getTicker(array $assetNames)
    {
        $tickerRequest = new TickerRequest($assetNames);

        return $this->doRequest($tickerRequest);
    }

    /**
     * @param string $assetPair
     * @param int|null $count
     *
     * @return ResponseInterface|OrderBookResponse
     */
    public function getOrderBook($assetPair, $count = null)
    {
        $orderBookRequest = new OrderBookRequest($assetPair, $count);

        return $this->doRequest($orderBookRequest);
    }

    /**
     * @param bool $trades
     * @param null $userref
     *
     * @return ResponseInterface|OpenOrdersResponse
     */
    public function getOpenOrders($trades = false, $userref = null)
    {
        $orderBookRequest = new OpenOrdersRequest($trades, $userref);

        return $this->doRequest($orderBookRequest);
    }

    /**
     * @param bool $trades
     * @param null $userref
     * @param null|string $start
     * @param null|string $end
     * @param null|int $ofs
     * @param null|string $closetime
     *
     * @return ClosedOrdersResponse|ResponseInterface
     */
    public function getClosedOrders(
        $trades = false,
        $userref = null,
        $start = null,
        $end = null,
        $ofs = null,
        $closetime = null
    ) {
        $orderBookRequest = new ClosedOrdersRequest($trades, $userref, $start, $end, $ofs, $closetime);

        return $this->doRequest($orderBookRequest);
    }

    /**
     * @param string $assetPair
     * @param null|string $since
     *
     * @return ResponseInterface|RecentTradesResponse
     */
    public function getRecentTrades($assetPair, $since = null)
    {
        $recentTradeRequest = new RecentTradesRequest($assetPair, $since);

        return $this->doRequest($recentTradeRequest);
    }

    /**
     * @param string $assetPair
     * @param string $since
     * @return ResponseInterface|SpreadDataResponse
     */
    public function getSpreadData($assetPair, $since = null)
    {
        $spreadDataRequest = new SpreadDataRequest($assetPair, $since);

        return $this->doRequest($spreadDataRequest);
    }

    /**
     * @param string $info
     * @param array|null $assetPairs
     * @return ResponseInterface|TradableAssetPairsResponse
     */
    public function getTradableAssetPairs($info, array $assetPairs = null)
    {
        if (null !== $assetPairs) {
            $assetPairs = implode(',', $assetPairs);
        }
        $tradableAssetPairs = new TradableAssetPairsRequest($info, $assetPairs);

        return $this->doRequest($tradableAssetPairs);
    }

    /**
     * @param RequestInterface $requestInterface
     *
     * @return ResponseInterface
     */
    private function doRequest(RequestInterface $requestInterface)
    {
        return $this->request->execute($requestInterface, $this->requestOptions, $this->header);
    }
}
