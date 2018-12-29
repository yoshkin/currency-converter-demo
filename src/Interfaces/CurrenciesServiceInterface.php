<?php declare(strict_types = 1);

namespace AYashenkov\Interfaces;

interface CurrenciesServiceInterface
{
    /**
     * Get currencies list from currencies provider
     * @return array
     */
    public function getCurrencies() : array ;

    /**
     * Convert origin currency to desired
     * @param array $params
     * @return string
     */
    public function convertCurrency($params = array()) : float ;
}