<?php
/**
 * @author Alex Kusakin
 */

namespace TierPrice;

use \TierPrice\Cart\ProductFactory;
use \TierPrice\Price\Repository;
use \TierPrice\Price\Validator;

/**
 * Class ServiceLocator
 */
class ServiceLocator
{
    /**
     * @var Repository
     */
    private static $repository;

    /**
     * Get new terminal object
     *
     * @return Terminal
     */
    public static function getTerminal()
    {
        return new Terminal(
            self::getRepository(),
            self::getCart(),
            self::getCartTotal()
        );
    }

    /**
     * Get repository object
     *
     * @return Repository
     */
    public static function getRepository()
    {
        if (!self::$repository) {
            self::$repository = new Repository(
                new Validator()
            );
        }

        return self::$repository;
    }

    /**
     * @return Cart
     */
    public static function getCart()
    {
        return new Cart(
            self::getRepository(),
            new ProductFactory()
        );
    }

    /**
     * @return Cart\Total
     */
    public static function getCartTotal()
    {
        return new Cart\Total(self::getRepository());
    }
}
