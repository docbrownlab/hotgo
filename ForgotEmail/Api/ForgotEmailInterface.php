<?php

namespace Tatix\ForgotEmail\Api;

interface ForgotEmailInterface
{
    /**
     * Get Email by Taxvat;
     *
     * @param string $taxvat
     * @return bool
     */
    public function get($taxvat);

}