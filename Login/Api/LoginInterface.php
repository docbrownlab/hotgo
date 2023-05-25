<?php
namespace Tatix\Login\Api;

interface LoginInterface
{
    /**
     * GET for Post api
     * @param string $usuario
     * @param string $senha
     * @param string $pais
     * @param string $operadora
     * @return string
     */
    public function getPost(
        $usuario  = null,
        $senha  = null,
        $pais  = null,
        $operadora  = null
    );
}

