<?php

namespace Anax\Kernel;

/**
 * Anax base class for an application.
 *
 */
class CAnax
{
    use \Anax\DI\TInjectable, \Anax\MVC\TRedirectHelpers;



    /**
     * Construct.
     *
     * @param array $di dependency injection of service container.
     */
    public function __construct($di)
    {
        $this->di = $di;
    }
}
