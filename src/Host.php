<?php

namespace WebDollar\WebDollarClientBundle;

use WebDollar\WebDollarClientBundle\Contracts\HostInterface;

/**
 * Class Host
 * @package WebDollar\WebDollarClientBundle
 */
class Host implements HostInterface
{
    /**
     * @var string
     */
    protected $_sUrl;

    /**
     * @var string
     */
    protected $_sScheme;

    /**
     * @var string
     */
    protected $_sHost;

    /**
     * @var int
     */
    protected $_nPort;

    /**
     * @var string
     */
    protected $_sUser;

    /**
     * @var string
     */
    protected $_sPassword;

    public function __construct(string $dsn)
    {
        $this->_processParts($dsn);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->_sUrl;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->_sHost;
    }

    /**
     * @return int|string
     */
    public function getPort()
    {
        return $this->_nPort;
    }

    /**
     * @return string
     */
    public function getScheme()
    {
        return $this->_sScheme;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->_sUser;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->_sPassword;
    }

    protected function _processParts(string $sDsn)
    {
        $aParts = \parse_url($sDsn);

        $this->_sScheme   = $aParts['scheme'] ?? 'http';
        $this->_nPort     = $aParts['port']   ?? $this->_sScheme === 'http' ? 80 : 443;
        $this->_sHost     = $aParts['host'];
        $this->_sUser     = $aParts['user'];
        $this->_sPassword = $aParts['password'];
        $this->_sUrl      = sprintf('%s://%s:%s', $this->_sScheme, $this->_sHost, $this->_nPort);
    }
}
