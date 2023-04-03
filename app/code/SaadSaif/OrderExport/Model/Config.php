<?php

namespace SaadSaif\OrderExport\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    const CONFIG_PATH_ENABLED = "sales/order_export/enabled";
    const CONFIG_PATH_API_URL = "sales/order_export/api_url";
    const CONFIG_PATH_API_TOKEN = "sales/order_export/api_token";
    const CONFIG_PATH_EXPEDITED_SKUS = "sales/order_export/expedite_skus";
    const CONFIG_PATH_EXPEDITED_MESSAGE = "sales/order_export/expedite_message";

    private ScopeConfigInterface $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param string $scopeType
     * @param string|null $scopeCode
     * @return bool
     */
    public function isEnabled(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): bool
    {
        return $this->scopeConfig->isSetFlag(self::CONFIG_PATH_ENABLED, $scopeType, $scopeCode);
    }

    public function getApiUrl(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): string
    {
        $value = $this->scopeConfig->getValue(self::CONFIG_PATH_API_URL, $scopeType, $scopeCode);
        return ($value != null) ? (string) $value : '';
    }

    public function getApiToken(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): string
    {
        $value = $this->scopeConfig->getValue(self::CONFIG_PATH_API_TOKEN, $scopeType, $scopeCode);
        return ($value != null) ? (string) $value : '';
    }

    public function getExpeditedSKUList(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): array
    {
        $value = $this->scopeConfig->getValue(self::CONFIG_PATH_EXPEDITED_SKUS, $scopeType, $scopeCode);
        $skus = ($value != null) ? explode(',', $value) : [];
        return array_map('trim', $skus);
    }

    public function getExpeditedMessage(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): string
    {
        return (string) $this->scopeConfig->getValue(self::CONFIG_PATH_EXPEDITED_MESSAGE, $scopeType, $scopeCode);
    }
}
