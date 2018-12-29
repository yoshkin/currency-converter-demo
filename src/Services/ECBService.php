<?php declare(strict_types = 1);
namespace AYashenkov\Services;

use AYashenkov\Interfaces\CurrenciesServiceInterface;
use Thelia\CurrencyConverter\CurrencyConverter;
use Thelia\CurrencyConverter\Provider\ECBProvider;
use Thelia\Math\Number;

/**
 * Used for get currencies list and convert original currency to desired
 * Class ECBService
 * @package AYashenkov\Services
 */
class ECBService implements CurrenciesServiceInterface
{
    /* @var ECBProvider */
    protected $provider;

    /**
     * ECBService constructor.
     * @param ECBProvider $provider
     */
    public function __construct(ECBProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Returns currencies list form provider
     * @return array
     */
    public function getCurrencies(): array
    {
        $currencies = [];
        try {
            foreach ($this->provider->getData() as $k => $v) {
                $currencies[] = (string)$v['currency'];
            }
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
        return $currencies;
    }

    /**
     * Returns converted currency value
     *
     * @param array $params
     * @return string
     */
    public function convertCurrency($params = array()): float
    {
        $converted = '';
        try {
            $currencyConverter = new CurrencyConverter($this->provider);
            $baseValue = new Number($params['amount']);

            $convertedValue = $currencyConverter
                ->from(strtoupper($params['from']))
                ->to(strtoupper($params['to']))
                ->convert($baseValue);
            $converted = $convertedValue->getNumber();
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
        return $converted;
    }
}