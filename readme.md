## Magento 2 professional training

---

### DI config

If you search for "carriers/fedex/password" in di.xml files, you'll find one more thing that needs attention:

>Magento Core Concept
>>If migrating database values from one environment to another, remember that encrypted values will be unreadable in environments with a different encryption key.

If you search for "carriers/fedex/password" in di.xml files, you'll find one more thing that needs attention:

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

---

### Create new entity with DB schema

`db_schema.xml` `module-cms` `cms_block` is most vanilla form.

foreign key: `TABLE_COLUMN_REFERENCE_TABLE_REFRERENCE_COLUMN`

```xml
<constraint xsi:type="foreign" referenceId="CMS_BLOCK_STORE_BLOCK_ID_CMS_BLOCK_BLOCK_ID" table="cms_block_store"
                    column="block_id" referenceTable="cms_block" referenceColumn="block_id" onDelete="CASCADE"/>
```
when ever you update or delete db schema, you should update the whitelist.json also

---

### Creating custom entity 
`Entity Model`
`Entity Interface`
`Resource Model` 
`Resource Collection`

Entity model will be extending `Magento\Framework\Model\AbstractModel` that gives the magic methods.
Resource model will hydrate our entity model.

Create the preference on the entity interface for the entity model.
Create the entity model from entity interface factory and load using the resource model.

```php
$exportDetails = $this->orderExportDetailsInterfaceFactory->create();
$this->orderExportDetailsResource->load($exportDetails, 1);
```

---

### Service layer contains `entity interface (service contract)` and `repository`
The purpose of the repository is to create unified API for the entity.
for filtering, sorting and ordering a collection we have a unified searchCriteriaInterface. 

---

>Magento Core Concept
>>In this case, leave the fully qualified class names for the @return and @param docblock comments. If we were to introduce support for the web API in the future, Magento uses reflection on our interfaces to wire up this functionality, and aliases won't be understood.

like: 
```php
/**
 * @return \Magento\Framework\Api\SearchResultsInterfaceOrderExportDetailsInterface[]
 */
public function getItems();
```

---

>>> The goal of extension attribute is to work seamlessly with the new entity considering as the part of the original entity

---
### Chapter 6 included
- Injecting a custom UI component into the checkout interface
- Using a LayoutProcessorInterface to load dynamic data into the checkout JS layout
- Creating a theme
- Basic LESS structure and the use of _theme.less and _extend.less
- The usage of view.xml
- Translation via CSV files in i18n

---
### Chapter 7 included
- Adding a resource with acl.xml and requiring that permission in several areas
- Adding an admin menu item with menu.xml
- Modifying the data source for a UI grid component
- Adding a new column to a UI grid component
