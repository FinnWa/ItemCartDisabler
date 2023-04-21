<?php

namespace ItemCartDisabler\Visibility;

use Shopware\Core\System\SystemConfig\SystemConfigService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AddToCartButtonModalDisabler extends AbstractExtension
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
            new TwigFunction('should_show_modal', [$this, 'showModal'])
        ];
    }

    public function showModal(): bool
    {
        $statusModal = $this->systemConfig->get('ItemCartDisabler.config.statusModal');

        if ($statusModal === true) {
            return true;
        }

        return false;
    }

}