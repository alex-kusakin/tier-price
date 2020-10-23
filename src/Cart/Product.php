<?php
/**
 * @author Alex Kusakin
 */

namespace TierPrice\Cart;

/**
 * Cart Product
 */
class Product
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var int
     */
    private $qty;

    /**
     * Item constructor.
     * @param $code
     * @param $qty
     */
    public function __construct($code, $qty)
    {
        $this->setCode($code);
        $this->setQty($qty);
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return Product
     */
    public function setCode($code)
    {
        $this->code = (string) $code;
        return $this;
    }

    /**
     * @return int
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * @param int $qty
     * @return Product
     */
    public function setQty($qty)
    {
        $this->qty = (int) $qty;
        return $this;
    }

    /**
     * @param $increment
     * @return Product
     */
    public function addQty($increment)
    {
        $this->qty += (int) $increment;
        return $this;
    }

    /**
     * @param $decrement
     * @return Product
     */
    public function removeQty($decrement)
    {
        $this->qty -= (int) $decrement;
        return $this;
    }

}
