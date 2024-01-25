# Krokedil\Shipping\Assets\AssetsRegistry  

Class AssetsRegistry

Class that stores the assets that should be enqueued.  





## Methods

| Name | Description |
|------|-------------|
|[__construct](#assetsregistry__construct)|Class constructor.|
|[add_script](#assetsregistryadd_script)|Add a script to the registry.|
|[add_style](#assetsregistryadd_style)|Add a style to the registry.|
|[enqueue_assets](#assetsregistryenqueue_assets)|Enqueue the scripts and styles.|
|[get_asset_url](#assetsregistryget_asset_url)|Get the URL of an asset in the package|
|[register_assets](#assetsregistryregister_assets)|Register the scripts and styles.|




### AssetsRegistry::__construct  

**Description**

```php
public __construct (void)
```

Class constructor. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


<hr />


### AssetsRegistry::add_script  

**Description**

```php
public add_script (\Script $script)
```

Add a script to the registry. 

 

**Parameters**

* `(\Script) $script`
: The script to add.  

**Return Values**

`void`




<hr />


### AssetsRegistry::add_style  

**Description**

```php
public add_style (\Style $style)
```

Add a style to the registry. 

 

**Parameters**

* `(\Style) $style`
: The style to add.  

**Return Values**

`void`




<hr />


### AssetsRegistry::enqueue_assets  

**Description**

```php
public enqueue_assets (void)
```

Enqueue the scripts and styles. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`




<hr />


### AssetsRegistry::get_asset_url  

**Description**

```php
public get_asset_url (string $asset)
```

Get the URL of an asset in the package 

 

**Parameters**

* `(string) $asset`
: The asset to get the URL for. The path of the file from the assets folder.  

**Return Values**

`string`




<hr />


### AssetsRegistry::register_assets  

**Description**

```php
public register_assets (void)
```

Register the scripts and styles. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`




<hr />

