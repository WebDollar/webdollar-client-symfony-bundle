<?php

namespace WebDollar\WebDollarClientBundle;

use WebDollar\Client\WebDollarClient;
use WebDollar\WebDollarClientBundle\Contracts\WebDollarClientManagerInterface;

/**
 * Class WebDollarClientManager
 * @package WebDollar\WebDollarClientBundle
 */
class WebDollarClientManager implements WebDollarClientManagerInterface
{
    /**
     * @var array|iterable
     */
    private $_aClients = [];

    public function __construct(iterable $clients)
    {
        $this->_aClients = $clients;
    }

    /**
     * @return WebDollarClient
     */
    public function getOneClient()
    {
        $nClientId = array_rand($this->_aClients);

        return $this->_aClients[$nClientId];
    }
}
