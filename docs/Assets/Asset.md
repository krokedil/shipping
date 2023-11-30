# Krokedil\Shipping\Assets\Asset  

Asset base class.

Contains the common properties and methods for all asset types  





## Methods

| Name | Description |
|------|-------------|
|[__construct](#asset__construct)|Class constructor.|
|[enqueue](#assetenqueue)|Enqueue the asset.|
|[get_admin](#assetget_admin)|Get whether or not the asset is for the admin pages.|
|[get_deps](#assetget_deps)|Get the dependencies of the asset.|
|[get_handle](#assetget_handle)|Get the handle of the asset.|
|[get_src](#assetget_src)|Get the source of the asset. As a URL to the file.|
|[get_version](#assetget_version)|Get the version of the asset.|
|[register](#assetregister)|Register the asset.|




### Asset::__construct  

**Description**

```php
public __construct (string $handle, string $src, string[] $deps, string $version, bool $admin)
```

Class constructor. 

 

**Parameters**

* `(string) $handle`
: The handle of the asset.  
* `(string) $src`
: The source of the asset. As a URL to the file.  
* `(string[]) $deps`
: The dependencies of the asset.  
* `(string) $version`
: The version of the asset.  
* `(bool) $admin`
: Whether or not the asset is for the admin pages.  

**Return Values**

`void`


<hr />


### Asset::enqueue  

**Description**

```php
public enqueue (void)
```

Enqueue the asset. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`




<hr />


### Asset::get_admin  

**Description**

```php
public get_admin (void)
```

Get whether or not the asset is for the admin pages. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`bool`




<hr />


### Asset::get_deps  

**Description**

```php
public get_deps (void)
```

Get the dependencies of the asset. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string[]`




<hr />


### Asset::get_handle  

**Description**

```php
public get_handle (void)
```

Get the handle of the asset. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### Asset::get_src  

**Description**

```php
public get_src (void)
```

Get the source of the asset. As a URL to the file. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### Asset::get_version  

**Description**

```php
public get_version (void)
```

Get the version of the asset. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### Asset::register  

**Description**

```php
public register (void)
```

Register the asset. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`




<hr />

