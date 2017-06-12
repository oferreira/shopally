<?php
declare(strict_types=1);

namespace Shopally\Store;

use \Exception;
use \Shopally\Store\Exception\{
    AddProductException, DeleteProductException, UpdateProductException, CleanBasketException
};
use \Shopally\Store\Entity\Product;

/**
 * Class Basket
 * @package Shopally\Store
 */
class Basket
{
    /**
     * Basket constructor.
     */
    public function __construct()
    {
        isset($_SESSION['basket']) ?: $this->setItems([]);
    }

    /**
     * @return Product[]
     */
    public function getItems(): array
    {
        return $_SESSION['basket'];
    }

    /**
     * @param array $items
     */
    public function setItems(array $items)
    {
        $_SESSION['basket'] = $items;
    }


    /**
     * @param Product $product
     * @param int     $qty
     * @param array   $options
     *
     * @return Basket
     * @throws AddProductException
     */
    public function add(Product $product, int $qty = 1, array $options = [])
    {
        try {
            if (!$qty) throw new Exception('The quantity added is <= 0');

            $product->setQty($qty);
            $product->setOptions($options);

            $items = $this->getItems();
            $items[$product->getHash()] = $product;

            $this->setItems($items);
        } catch (Exception $e) {
            throw new AddProductException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }


    /**
     * @return Basket
     * @throws CleanBasketException
     */
    public function clean()
    {
        try {
            $this->setItems([]);
        } catch (Exception $e) {
            throw new CleanBasketException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }

    /**
     * @param string $hash
     *
     * @return Basket
     * @throws DeleteProductException
     */
    public function delete(string $hash)
    {
        try {
            $items = $this->getItems();

            if (!isset($items[$hash])) throw new Exception("item {$hash} not found ");
            unset($items[$hash]);

            $this->setItems($items);
        } catch (Exception $e) {
            throw new DeleteProductException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }

    /**
     * @param string $hash
     * @param int    $qty
     * @param array  $options
     *
     * @return Basket
     * @throws UpdateProductException
     */
    public function update(string $hash, int $qty, array $options = [])
    {
        try {
            if (!$qty) throw new Exception('The quantity added is <= 0');

            $items = $this->getItems();

            $items[$hash]->setQty($qty);
            $items[$hash]->setOptions($options);

            $this->setItems($items);
        } catch (Exception $e) {
            throw new UpdateProductException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }
}