<?php

// require_once 'vendor/cocur/slugify/src/RuleProvider/RuleProviderInterface.php';
// require_once 'vendor/cocur/slugify/src/RuleProvider/DefaultRuleProvider.php';
// require_once 'vendor/cocur/slugify/src/SlugifyInterface.php';
// require_once 'vendor/cocur/slugify/src/Slugify.php';
use Cocur\Slugify\Slugify;

namespace classes;


class Slugifi
{
    /**
     * Função que pega um valor texto normal e convert para slug.
     * Objetivo: retornar um valor trabalhado para ser utilizado como parâmetro na url.
     *
     * @param string $value_slug
     * @return string
     */
    public static function convert($valueSlug = null)
    {
        // Verifica se foi passado valor.
        if (empty($valueSlug)) {
            return false;
        }

        // Pega o valor, transforma em slug e retorna.
        $slugify = new Slugify();
        return $slugify->slugify($valueSlug);
    }
}
