<?php
declare(strict_types=1);

namespace Shopally\Exception;

abstract class BaseException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }


    protected function report(string $path)
    {
        foreach ($GLOBALS['config']['exception']['rules'] as $k => $rule) {
            if (isset($rule['enabled']) && !$rule['enabled']) continue;

            if (preg_match($rule['rule'], $path)) {
                $this->action($rule);
                break;
            }
        }
    }

    private function action(array $rule)
    {
        switch ($rule['out']) {
            case 'file':
                // write on file
                break;
            case 'mail':
                // send a email
                break;
        }
    }

}