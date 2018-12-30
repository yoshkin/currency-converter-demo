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
                if ($v['currency']) {
                    $currencies[] = (string) $v['currency'];
                } else {
                    throw new \LogicException('Currency provider does not contain data (currencies list)');
                }
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
    public function convertCurrency($params = array()): string
    {
        $converted = '';
        try {
            if (!$this->validateParams($params)) {
                throw new \LogicException('Not valid data (from, to, amount)');
            }
            $currencyConverter = new CurrencyConverter($this->provider);
            $baseValue = new Number($params['amount']);

            $convertedValue = $currencyConverter
                ->from(strtoupper($params['from']))
                ->to(strtoupper($params['to']))
                ->convert($baseValue);
            $converted = (string) $convertedValue->getNumber();
        } catch (\LogicException $exception) {
            echo $exception->getMessage();
        }
        return $converted;
    }

    /**
     * Validate $params array: keys and values
     * @param array $params ['from'=> '', 'to' => '', 'amount' => '']
     * @return bool
     */
    public function validateParams($params = array()): bool
    {
        $testKeys = ['from' => '', 'to' => '', 'amount' => ''];
        $result = false;
        if ( is_array($params) ) {
            if ( !array_diff_key($testKeys, $params) === false ) {
                return $result;
            }
            if ( !empty($params['from']) && !empty($params['to']) && !empty($params['amount']) ) {
                //check that amount is number
                if ( is_numeric($params['amount'])) {
                    $result = true;
                }
            }
        }
        return $result;
    }
}