<?php

namespace Imj;

/**
 * Interface ServiceProviderInterface
 * @package Imj
 */
interface ServiceProviderInterface
{
    public function register(Registry $registry);
}
