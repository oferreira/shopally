<?php
declare(strict_types=1);

namespace Shopally\Store\Exception;

use \Shopally\Exception\BaseException;

/**
 * Class UpdateProductException
 * @package Shopally\Store\Exception
 */
final class UpdateProductException extends BaseException
{
    /**
     * UpdateProductException constructor.
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->report(__FILE__);
    }
}