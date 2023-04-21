<?php

namespace ItemCartDisabler\Visibility;

use Shopware\Core\System\SystemConfig\SystemConfigService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AddToCartButtonDisabler extends AbstractExtension
{
    private $systemConfig;

    public function __construct(
        SystemConfigService $systemConfig
    )
    {
        $this->systemConfig = $systemConfig;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('should_show', [$this, 'shouldShow']),
        ];
    }

    public function shouldShow($productId): bool
    {
        $pluginActive = $this->systemConfig->get('ItemCartDisabler.config.status');
        if(!$pluginActive){
            return false;
        }

        $hideAllCarts = $this->systemConfig->get('ItemCartDisabler.config.statusAll');
        if($hideAllCarts){
            return true;
        }

        $hideSpecificCarts = $this->systemConfig->get('ItemCartDisabler.config.statusSpecific');
        if(!$hideSpecificCarts){
            return false;
        }

        return $this->isInHideSpecificCartList($productId);
    }

    public function isInHideSpecificCartList($productId): bool
    {
        if (in_array($productId,
            $this->systemConfig->get('ItemCartDisabler.config.exampleMultiProductIds'))
        ) {
            return true;
        }

        return false;
    }
}