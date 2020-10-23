<?php
/**
 * @author Alex Kusakin
 */

namespace TierPrice\Cart;

/**
 * Create cart product
 * @package TierPrice\Cart
 */
class ProductFactory
{
    /**
     * Create cart product object
     *
     * @param string $code
     * @param int $qty
     * @return Product
     */
    public function create($code, $qty)
    {
        return new Product($code, $qty);
    }
}
