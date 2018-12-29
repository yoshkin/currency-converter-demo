<?php declare(strict_types=1);

namespace AYashenkov\Http\Controllers\Api;

use AYashenkov\Interfaces\CurrenciesServiceInterface;
use Http\Response;

class ConverterController
{
    /** @var Response */
    private $response;

    /** @var CurrenciesServiceInterface */
    private $service;

    /**
     * ConverterController constructor.
     * @param Response $response
     * @param CurrenciesServiceInterface $service
     */
    public function __construct(
        Response $response,
        CurrenciesServiceInterface $service
    )
    {
        $this->response = $response;
        $this->service = $service;
    }

    /**
     * Set response to frontend: converted currency value
     * @param array $params ['from'=> '', 'to' => '', 'amount' => '']
     */
    public function index($params)
    {
        $content = $this->service->convertCurrency($params);
        $this->response->setHeader('Content-type', 'application/json');
        $this->response->setContent($content);
    }
}