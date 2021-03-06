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

    /**
     * @return WebDollarClient
     */
    public function getOneClient()
    {
        $nClientId = array_rand($this->_aClients);

        return $this->_aClients[$nClientId];
    }

    public function getClientByAlias($alias)
    {
        return $this->_aClients[$alias] ?? NULL;
    }

    public function getClients(): array
    {
        return $this->_aClients;
    }

    public function addClient(WebDollarClient $oClient, $alias)
    {
        $this->_aClients[$alias] = $oClient;
    }
}
