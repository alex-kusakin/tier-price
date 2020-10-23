<?php
/**
 * @author Alex Kusakin
 */

namespace TierPrice\Cart;

use TierPrice\Cart;
use TierPrice\Price\Repository;

/**
 * Cart total price calculation
 */
class Total
{
    const PRICE_ROUND_PRECISION = 2;

    /**
     * @var Repository
     */
    protected $repository;

    /**
     * Total constructor.
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get whole cart total price
     *
     * @param Cart $cart
     * @return float
     * @throws \Exception
     */
    public function getCartTotal(Cart $cart)
    {
        $totalPrice = 0;
        foreach ($cart->getProducts() as $product) {
            $totalPrice += $this->getProductTotal($product);
        }

        return $totalPrice;
    }

    /**
     * Get cart product total price
     *
     * @param Product $product
     * @return float
     * @throws \Exception
     */
    public function getProductTotal(Product $product)
    {
        $total = 0;
        $prices = $this->repository->get($product->getCode());

        $remainedQty = $product->getQty();
        krsort($prices);

        foreach ($prices as $qty => $price) {
            $tierQty = (int) ($remainedQty / $qty);
            $remainedQty = $remainedQty % $qty;
            $total += $tierQty * $this->roundPrice($price);
        }

        return $total;
    }

    /**
     * @param float $price
     * @return float
     */
    protected function roundPrice($price)
    {
        return round($price, self::PRICE_ROUND_PRECISION);
    }
}
