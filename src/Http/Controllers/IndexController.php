<?php declare(strict_types=1);

namespace AYashenkov\Http\Controllers;

use AYashenkov\Interfaces\CurrenciesServiceInterface;
use AYashenkov\Interfaces\RendererInterface;
use Http\Response;

class IndexController
{
    /** @var Response */
    private $response;

    /** @var RendererInterface */
    private $renderer;

    /** @var CurrenciesServiceInterface */
    private $service;

    /**
     * IndexController constructor.
     * @param Response $response
     * @param RendererInterface $renderer
     * @param CurrenciesServiceInterface $service
     */
    public function __construct(
        Response $response,
        RendererInterface $renderer,
        CurrenciesServiceInterface $service
    )
    {
        $this->response = $response;
        $this->renderer = $renderer;
        $this->service = $service;
    }

    /**
     * Set response to frontend: index.html with currencies list
     */
    public function index()
    {
        $data = [
            'currencies' => $this->service->getCurrencies(),
        ];
        $html = $this->renderer->render('index.html', $data);
        $this->response->setContent($html);
    }
}