<?php

namespace WebDollar\WebDollarClientBundle\Contracts;

/**
 * Interface HostInterface
 * @package WebDollar\WebDollarClientBundle\Contracts
 */
interface HostInterface
{
    /**
     * @return string
     */
    public function getUrl();

    /**
     * @return string
     */
    public function getHost();

    /**
     * @return string
     */
    public function getPort();

    /**
     * @return string
     */
    public function getScheme();

    /**
     * @return string
     */
    public function getUser();

    /**
     * @return string
     */
    public function getPassword();
}
