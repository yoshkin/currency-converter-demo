<?php declare(strict_types = 1);

namespace AYashenkov\Interfaces;

interface CurrenciesServiceInterface
{
    /**
     * Get currencies list from currencies provider
     * @return array
     */
    public function getCurrencies(): array;

    /**
     * Convert origin currency to desired
     * @param array $params ['from'=> '', 'to' => '', 'amount' => '']
     * @return string
     */
    public function convertCurrency($params = array()): string ;

    /**
     * Validate $params array: keys and values
     * @param array $params ['from'=> '', 'to' => '', 'amount' => '']
     * @return bool
     */
    public function validateParams($params = array()): bool;

}