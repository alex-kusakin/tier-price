<?php
/**
 * @author Alex Kusakin
 */

namespace TierPrice;

use \TierPrice\Price\Repository;
use \TierPrice\Cart\Total;

/**
 * Class Terminal
 * @package TierPrice
 */
class Terminal
{
    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @var Total
     */
    protected $totalCalculator;

    /**
     * @var Cart
     */
    protected $cart;

    /**
     * Terminal constructor.
     * @param Repository $repository
     * @param Cart $cart
     * @param Total $totalCalculator
     */
    public function __construct(
        Repository $repository,
        Cart $cart,
        Total $totalCalculator
    ) {
        $this->repository = $repository;
        $this->cart = $cart;
        $this->totalCalculator = $totalCalculator;
    }

    /**
     * Init terminal with products data.
     * Data array format:
     * $pricingData = [
     *    "A" => [1 => 2.00, 4 => 7.00],
     *    "B" => [1 => 12.00],
     *    "C" => [1 => 1.25, 6 => 6.00],
     *    "D" => [1 => 0.15],
     * ]
     *
     * @param array $pricingData
     * @throws \Exception
     */
    public function setPricing(array $pricingData)
    {
        $this->repository->setData($pricingData);
    }

    /**
     * Scan product, like add it to cart
     *
     * @param string $code
     * @return $this
     * @throws \Exception
     */
    public function scan($code)
    {
        $this->cart->addProduct($code);
        return $this;
    }

    /**
     * Get cart total price
     *
     * @return float
     * @throws \Exception
     */
    public function getTotal()
    {
        return $this->totalCalculator->getCartTotal($this->cart);
    }
}
