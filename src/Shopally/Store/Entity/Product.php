<?php
declare(strict_types=1);

namespace Shopally\Store\Entity;

/**
 * Class Product
 * @package Shopally\Store\Entity
 */
class Product
{
    private $id;
    private $qty;
    private $hash;
    private $name;
    private $options = [];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Product
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        $this->createHash();

        return $this;
    }

    /**
     * @return int
     */
    public function getQty(): int
    {
        return $this->qty;
    }

    /**
     * @param int $qty
     *
     * @return Product
     */
    public function setQty($qty): self
    {
        $this->qty = $qty;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Product
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHash(): string
    {
        if (empty($this->hash)) $this->createHash();

        return $this->hash;
    }

    public function createHash(): string
    {
        $this->hash = md5($this->id . time());

        return $this->hash;
    }

    /**
     * @param mixed $hash
     *
     * @return Product
     */
    public function setHash($hash): self
    {
        $this->hash = $hash;

        return $this;
    }


    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     *
     * @return Product
     */
    public function setOptions(array $options): self
    {
        $this->options = (array)$options;

        return $this;
    }
}