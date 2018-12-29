<?php declare(strict_types = 1);

namespace AYashenkov\Interfaces;

interface RendererInterface
{
    /**
     * Render template to frontend
     * @param $template (for example 'index.html')
     * @param array $data
     * @return string
     */
    public function render($template, $data = []) : string;
}