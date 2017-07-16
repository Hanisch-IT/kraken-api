<?php
/**
 * @author Fabian Hanisch
 * @since 16.07.2017 02:40
 * @version 1.0
 */

namespace HanischIt\KrakenApi\Service\RequestService;

use HanischIt\KrakenApi\Enum\RequestMethodEnum;
use HanischIt\KrakenApi\External\HttpClient;
use HanischIt\KrakenApi\Model\Header;
use HanischIt\KrakenApi\Model\RequestInterface;
use HanischIt\KrakenApi\Model\RequestOptions;

/**
 * Class PostRequest
 * @package HanischIt\KrakenApi\Service\RequestService
 */
class PostRequest
{
    /**
     * @var HttpClient
     */
    private $client;
    /**
     * @var RequestHeader
     */
    private $requestHeader;

    /**
     * Request constructor.
     * @param HttpClient $client
     * @param RequestHeader $requestHeader
     */
    public function __construct(HttpClient $client, RequestHeader $requestHeader)
    {
        $this->client = $client;
        $this->requestHeader = $requestHeader;
    }

    /**
     * @param RequestInterface $request
     * @param RequestOptions $requestOptions
     * @param Header $header
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function execute(RequestInterface $request, RequestOptions $requestOptions, Header $header)
    {
        $nonce = $this->getNonce();
        $requestData = $request->getRequestData();
        $requestData["nonce"] = $nonce;
        $path = $requestOptions->getEndpoint() . $requestOptions->getVersion() . "/private/" . $request->getMethod();
        return $this->client->request(RequestMethodEnum::REQUEST_METHOD_POST, $path, [
            'headers' => $this->requestHeader->asArray($header, $requestData, "/" . $requestOptions->getVersion() . "/private/" . $request->getMethod(), $nonce),
            'form_params' => $requestData
        ]);
    }

    /**
     * @return string
     */
    private function getNonce()
    {
        $nonce = explode(' ', microtime());
        $nonce = $nonce[1] . str_pad(substr($nonce[0], 2, 6), 6, '0');

        return $nonce;
    }
}
