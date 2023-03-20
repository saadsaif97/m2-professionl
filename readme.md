## Magento 2 professional training

---

### DI config

If you search for "carriers/fedex/password" in di.xml files, you'll find one more thing that needs attention:

>Magento Core Concept
>>If migrating database values from one environment to another, remember that encrypted values will be unreadable in environments with a different encryption key.

```xml
<type name="Magento\Config\Model\Config\TypePool">
    <arguments>
        <argument name="sensitive" xsi:type="array">
            ...
            <item name="carriers/fedex/password" xsi:type="string">1</item>
            ...
        </argument>
        ...
    </arguments>
</type>
```

Another example of injecting arguments with DI config, this registers the config path as a "sensitive" value with Magento. Sensitive and environment-specific values are written to app/etc/env.php (not intended for version control) instead of app/etc/config.php (is intended for version control) if config values are dumped to disk. It's best practice to include this di.xml configuration for our own "sales/order_export/api_token" config path. (In fact, it's not a bad idea to inject our "sales/order_export/api_url" path into the "environment" argument of the same core class; it's reasonable to expect this value would differ between environments.)
