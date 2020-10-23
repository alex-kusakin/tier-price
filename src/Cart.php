<?php
/**
 * @author Alex Kusakin
 */

namespace TierPrice;

use \TierPrice\Price\Repository;
use \TierPrice\Cart\ProductFactory;
use \TierPrice\Exception\ValidationException;

/**
 * Customer cart
 * @package TierPrice
 */
class Cart
{
    /**
     * @var Cart\Product[]
     */
    protected $products = [];

    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * Cart constructor.
     *
     * @param Repository $repository
     * @param ProductFactory $productFactory
     */
    public function __construct(
        Repository $repository,
        ProductFactory $productFactory
    ) {
        $this->repository = $repository;
        $this->productFactory = $productFactory;
    }

    /**
     * Add product to cart
     *
     * @param string $code
     * @param int $qty
     * @return $this
     * @throws \Exception
     */
    public function addProduct($code, $qty = 1)
    {
        $this->repository->verify($code);
        $this->validateQty($qty);

        $product = $this->getProduct($code);
        if (!$product) {
            $product = $this->productFactory->create($code, $qty);
            $this->products[] = $product;
        } else {
            $product->addQty($qty);
        }

        return $this;
    }

    /**
     * Get all products in cart
     *
     * @return Cart\Product[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param int $qty
     * @throws \Exception
     */
    protected function validateQty($qty)
    {
        if ($qty <= 0) {
            throw new ValidationException("Product quantity should be positive");
        }
    }

    /**
     * @param string $code
     * @return bool|Cart\Product
     */
    protected function getProduct($code)
    {
        foreach ($this->products as $product) {
            if ($product->getCode() == $code) {
                return $product;
            }
        }

        return false;
    }
}
