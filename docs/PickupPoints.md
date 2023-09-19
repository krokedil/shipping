# Krokedil\Shipping\PickupPoints  

Class PickupPoints.

Automatically gets pickup points from a WooCommerce shipping rate if the metadata for it exists.
And has functionality to add and remove pickup points from the shipping rate.  





## Methods

| Name | Description |
|------|-------------|
|[__construct](#pickuppoints__construct)|PickupPoints constructor. Automatically gets pickup points from a WooCommerce shipping rate if the metadata for it exists.|
|[add_pickup_point](#pickuppointsadd_pickup_point)|Add pickup point to WooCommerce shipping rate.|
|[array_to_json](#pickuppointsarray_to_json)|Convert an array to a JSON string.|
|[get_pickup_points](#pickuppointsget_pickup_points)|Get pickup points.|
|[get_rate](#pickuppointsget_rate)|Get WooCommerce shipping rate.|
|[json_to_array](#pickuppointsjson_to_array)|Convert a JSON string to an array.|
|[remove_pickup_point](#pickuppointsremove_pickup_point)|Remove pickup point from WooCommerce shipping rate.|
|[save_pickup_points_to_rate](#pickuppointssave_pickup_points_to_rate)|Save pickup points to WooCommerce shipping rate as a json string.|
|[set_pickup_points](#pickuppointsset_pickup_points)|Set pickup points.|
|[set_pickup_points_from_rate](#pickuppointsset_pickup_points_from_rate)|Get pickup points from WooCommerce shipping rate.|
|[set_rate](#pickuppointsset_rate)|Set WooCommerce shipping rate.|
|[to_array](#pickuppointsto_array)|Convert an object to an array.|




### PickupPoints::__construct  

**Description**

```php
public __construct (\WC_Shipping_Rate|null $rate)
```

PickupPoints constructor. Automatically gets pickup points from a WooCommerce shipping rate if the metadata for it exists. 

Can be passed null to create an empty PickupPoints object, that can then be manually populated. 

**Parameters**

* `(\WC_Shipping_Rate|null) $rate`
: WooCommerce shipping rate.  

**Return Values**

`void`




<hr />


### PickupPoints::add_pickup_point  

**Description**

```php
public add_pickup_point (\PickupPoint $pickup_point)
```

Add pickup point to WooCommerce shipping rate. 

 

**Parameters**

* `(\PickupPoint) $pickup_point`
: Pickup point.  

**Return Values**

`void`


<hr />


### PickupPoints::array_to_json  

**Description**

```php
public array_to_json (array $array)
```

Convert an array to a JSON string. 

 

**Parameters**

* `(array) $array`
: Array.  

**Return Values**

`string`




<hr />


### PickupPoints::get_pickup_points  

**Description**

```php
public get_pickup_points (void)
```

Get pickup points. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\PickupPoint[]`




<hr />


### PickupPoints::get_rate  

**Description**

```php
public get_rate (void)
```

Get WooCommerce shipping rate. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\WC_Shipping_Rate`




<hr />


### PickupPoints::json_to_array  

**Description**

```php
public json_to_array (string $json)
```

Convert a JSON string to an array. 

 

**Parameters**

* `(string) $json`
: JSON string.  

**Return Values**

`array`




<hr />


### PickupPoints::remove_pickup_point  

**Description**

```php
public remove_pickup_point (\PickupPoint $pickup_point)
```

Remove pickup point from WooCommerce shipping rate. 

 

**Parameters**

* `(\PickupPoint) $pickup_point`
: Pickup point.  

**Return Values**

`void`


<hr />


### PickupPoints::save_pickup_points_to_rate  

**Description**

```php
public save_pickup_points_to_rate (void)
```

Save pickup points to WooCommerce shipping rate as a json string. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


<hr />


### PickupPoints::set_pickup_points  

**Description**

```php
public set_pickup_points (\PickupPoint[] $pickup_points)
```

Set pickup points. 

 

**Parameters**

* `(\PickupPoint[]) $pickup_points`
: Pickup points.  

**Return Values**

`void`


<hr />


### PickupPoints::set_pickup_points_from_rate  

**Description**

```php
public set_pickup_points_from_rate (void)
```

Get pickup points from WooCommerce shipping rate. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


<hr />


### PickupPoints::set_rate  

**Description**

```php
public set_rate (\WC_Shipping_Rate $rate)
```

Set WooCommerce shipping rate. 

 

**Parameters**

* `(\WC_Shipping_Rate) $rate`
: WooCommerce shipping rate.  

**Return Values**

`void`


<hr />


### PickupPoints::to_array  

**Description**

```php
public to_array (object $object)
```

Convert an object to an array. 

 

**Parameters**

* `(object) $object`
: Object.  

**Return Values**

`void`


<hr />

