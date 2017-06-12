<?php

namespace Shopally\Store;

use PHPUnit\Framework\TestCase;
use Shopally\Store\Entity\Product;
use Shopally\Store\Exception\{
    AddProductException, DeleteProductException, UpdateProductException
};

/**
 * @covers Basket
 */
final class BasketTest extends TestCase
{

    /**
     * @var \Shopally\Store\Basket
     */
    protected $basket;

    /**
     * @var \Shopally\Store\Entity\Product
     */
    protected $product;

    protected function setUp()
    {
        $this->basket = new Basket();
        $this->product = new Product();
        $this->product->setId(1)->setName('product 1');
    }

    public function testCleanBasketWithSucess()
    {
        $this->basket->clean();
        $this->assertEmpty($this->basket->getItems(), "I should be have basket empty after clean");
    }

    public function testAddProductWithSucess()
    {
        $this->basket->clean();
        $this->basket->add($this->product);
        $this->assertNotEmpty($this->basket->getItems(), "I should be have basket no empty after having  added a product");
    }

    public function testAddProductWithGoodQuantity()
    {
        $qty = 2;
        $this->basket->clean();
        $this->basket->add($this->product, $qty);

        $this->assertEquals(current($this->basket->getItems())->getQty(), $qty, "I should be have product with quantity equal has {$qty}");
    }


    public function testAddProducWithFailure()
    {
        try {
            $qty = 0;
            $this->basket->add($this->product, $qty);
            $this->fail("I should be have generate a fail when i add a product with quantity equal has {$qty}");
        } catch (Exception $e) {
            $this->assertNotEmpty($e->getMessage(), "I should be have an Exception with a message");
        } catch (AddProductException $e) {
            $this->assertNotEmpty($e->getMessage(), "I should be have an Exception with a message");
        }
    }


    public function testDeleteAProductWithSucess()
    {
        $hash = $this->product->getHash();

        $this->basket->clean();
        $this->basket->add($this->product);
        $this->basket->delete($hash);

        $this->assertEmpty($this->basket->getItems(), "I should be have a basket empty when i delete the last product");
    }


    public function testDeleteAProductWithFailure()
    {
        try {
            $hash = 0;

            $this->basket->clean();
            $this->basket->add($this->product);
            $this->basket->delete($hash);

            $this->assertNotEmpty($this->basket->getItems(), "I should be have a basket not empty");

        } catch (Exception $e) {
            $this->assertNotEmpty($e->getMessage(), "I should be have an Exception with a message");
        } catch (DeleteProductException $e) {
            $this->assertNotEmpty($e->getMessage(), "I should be have an Exception with a message");
        }
    }


    public function testUpdateAProductWithSucess()
    {
        $this->basket->clean();

        // add product
        $this->product->setName('product 1');
        $this->basket->add($this->product, 1);

        // change name of product
        $this->product->setName('product 2');
        $this->basket->update($this->product->getHash(), 2, ['color' => 'red']);

        $item = current($this->basket->getItems());
        $this->assertEquals($item->getName(), 'product 2', "I should be have product with good name");
    }

    public function testUpdateAProductWithFailure()
    {
        try {
            $this->basket->clean();

            // add product
            $this->basket->add($this->product, 1);

            // change name of product
            $this->basket->update($this->product->getHash(), 0, ['color' => 'red']);

            $this->assertNotEmpty($this->basket->getItems(), "I should be have a basket not empty");
        } catch (Exception $e) {
            $this->assertNotEmpty($e->getMessage(), "I should be have an Exception with a message");
        } catch (UpdateProductException $e) {
            $this->assertNotEmpty($e->getMessage(), "I should be have an Exception with a message");
        }
    }
}
