<?php
/**
 * @author Alex Kusakin
 */

namespace TierPrice\Price;

use TierPrice\Exception\ValidationException;

/**
 * Validator or price data
 */
class Validator
{
    /**
     * Validate product code
     *
     * @param $code
     * @throws ValidationException
     */
    public function validateCode($code)
    {
        if (empty($code) || !is_string($code)) {
            throw new ValidationException('Product code should be not empty string.');
        }
    }

    /**
     * Validate prices array
     *
     * @param array $prices
     * @throws ValidationException
     */
    public function validatePrices(array $prices)
    {
        if (empty($prices) || !is_array($prices)) {
            throw new ValidationException('Product must have at least one price.');
        }

        $hasUnitPrice = false;
        foreach ($prices as $qty => $price) {
            if (empty($qty) || $qty <= 0) {
                throw new ValidationException('Price quantity should be greater than 0.');
            }

            if (empty($price) || $price <= 0) {
                throw new ValidationException('Price value should be greater than 0.');
            }

            if ($qty == 1) {
                $hasUnitPrice = true;
            }
        }

        if (!$hasUnitPrice) {
            throw new ValidationException('Product must have unit price (with qty = 1).');
        }
    }
}
