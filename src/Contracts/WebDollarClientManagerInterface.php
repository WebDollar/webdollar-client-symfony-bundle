<?php

namespace WebDollar\WebDollarClientBundle\Contracts;

use WebDollar\Client\WebDollarClient;

/**
 * Interface WebDollarClientManagerInterface
 * @package WebDollar\WebDollarClientBundle\Contracts
 */
interface WebDollarClientManagerInterface
{
    /**
     * @return WebDollarClient
     */
    public function getOneClient();

    /**
     * @param $alias
     *
     * @return WebDollarClient|NULL
     */
    public function getClientByAlias($alias);

    /**
     * @return WebDollarClient[]
     */
    public function getClients(): array;
}
