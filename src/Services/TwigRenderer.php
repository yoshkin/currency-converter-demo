<?php declare(strict_types = 1);
namespace AYashenkov\Services;

use AYashenkov\Interfaces\RendererInterface;
use Twig_Environment;

/**
 * Class TwigRenderer
 * @package AYashenkov\Services
 */
class TwigRenderer implements RendererInterface
{
    /* @var Twig_Environment */
    private $renderer;

    /**
     * TwigRenderer constructor.
     * @param Twig_Environment $renderer
     */
    public function __construct(Twig_Environment $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Render template to frontend
     *
     * @param $template
     * @param array $data
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function render($template, $data = []) : string
    {
        return $this->renderer->render($template, $data);
    }
}