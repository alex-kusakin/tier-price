<?php
/**
 * @author Alex Kusakin
 */

namespace TierPrice\Price;

use \TierPrice\Exception\NotFoundException;

/**
 * Product prices repository
 */
class Repository
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var Validator
     */
    protected $validator;

    /**
     * Repository constructor.
     * @param Validator $validator
     */
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Set multiple price data to repository
     *
     * @param array $data
     * @throws \Exception
     */
    public function setData(array $data)
    {
        $this->validateData($data);
        $this->data = array_merge($this->data, $data);
    }

    /**
     * Get raw price data from repository
     *
     * @param string $code
     * @return array
     * @throws \Exception
     */
    public function get($code)
    {
        $this->verify($code);

        return $this->data[$code];
    }

    /**
     * Add/update product price data to repository
     *
     * @param string $code
     * @param array $prices
     * @return $this
     * @throws \Exception
     */
    public function set($code, array $prices)
    {
        $this->validator->validateCode($code);
        $this->validator->validatePrices($prices);

        $this->data[$code] = $prices;

        return $this;
    }

    /**
     * Verify if product has price data
     *
     * @param string $code
     * @return $this
     * @throws \TierPrice\Exception\ValidationException
     * @throws NotFoundException
     */
    public function verify($code)
    {
        $this->validator->validateCode($code);
        if (!isset($this->data[$code])) {
            throw new NotFoundException("Product with code \"{$code}\" does not exist.");
        }

        return $this;
    }

    /**
     * @param $data
     * @throws \TierPrice\Exception\ValidationException
     */
    protected function validateData($data)
    {
        foreach ($data as $code => $prices) {
            $this->validator->validateCode($code);
            $this->validator->validatePrices($prices);
        }
    }
}
