<?php declare(strict_types=1);

namespace AYashenkov\Http\Controllers\Api;

use AYashenkov\Interfaces\CurrenciesServiceInterface;
use Http\Request;
use Http\Response;

class ConverterController
{
    /** @var Request */
    private $request;

    /** @var Response */
    private $response;

    /** @var CurrenciesServiceInterface */
    private $service;

    /**
     * ConverterController constructor.
     * @param Request $request
     * @param Response $response
     * @param CurrenciesServiceInterface $service
     */
    public function __construct(
        Request $request,
        Response $response,
        CurrenciesServiceInterface $service
    )
    {
        $this->request = $request;
        $this->response = $response;
        $this->service = $service;
    }

    /**
     * Set response to frontend: converted currency value
     * @param $params
     */
    public function index($params)
    {
        $content = $this->service->convertCurrency($params);
        $this->response->setHeader('Content-type', 'application/json');
        $this->response->setContent($content);
    }
}