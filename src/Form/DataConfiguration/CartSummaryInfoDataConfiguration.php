<?php

declare(strict_types=1);

namespace cdigruttola\Module\CartSummaryInfo\Form\DataConfiguration;

use cdigruttola\Module\CartSummaryInfo\Configuration\CartSummaryInfoConfiguration;
use PrestaShop\PrestaShop\Core\Configuration\AbstractMultistoreConfiguration;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Handles configuration data for demo multistore configuration options.
 */
final class CartSummaryInfoDataConfiguration extends AbstractMultistoreConfiguration
{
    private const CONFIGURATION_FIELDS = [
        'cart_summary_info_text',
        'cart_summary_info_active',
    ];

    /**
     * @return OptionsResolver
     */
    protected function buildResolver(): OptionsResolver
    {
        return (new OptionsResolver())
            ->setDefined(self::CONFIGURATION_FIELDS)
            ->setAllowedTypes('cart_summary_info_text', 'array')
            ->setAllowedTypes('cart_summary_info_active', 'bool');
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration(): array
    {
        $return = [];
        $shopConstraint = $this->getShopConstraint();

        $return['cart_summary_info_text'] = $this->configuration->get(CartSummaryInfoConfiguration::CART_SUMMARY_INFO_TEXT, null, $shopConstraint);
        $return['cart_summary_info_active'] = $this->configuration->get(CartSummaryInfoConfiguration::CART_SUMMARY_INFO_ACTIVE, true, $shopConstraint);

        return $return;
    }

    /**
     * {@inheritdoc}
     */
    public function updateConfiguration(array $configuration): array
    {
        $shopConstraint = $this->getShopConstraint();
        $this->updateConfigurationValue(CartSummaryInfoConfiguration::CART_SUMMARY_INFO_TEXT, 'cart_summary_info_text', $configuration, $shopConstraint, ['html' => true]);
        $this->updateConfigurationValue(CartSummaryInfoConfiguration::CART_SUMMARY_INFO_ACTIVE, 'cart_summary_info_active', $configuration, $shopConstraint);

        return [];
    }
}
