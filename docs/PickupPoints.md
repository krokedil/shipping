# Krokedil\Shipping\PickupPoints  

Class PickupPoints

Handles the pickup points service and any integraction with WooCommerce that is required for the package to work properly.
Offloading this from the plugins that implement it to a service class.  

## Implements:
Krokedil\Shipping\Interfaces\PickupPointServiceInterface



## Methods

| Name | Description |
|------|-------------|
|[__construct](#pickuppoints__construct)|Class constructor.|
|[add_hidden_order_itemmeta](#pickuppointsadd_hidden_order_itemmeta)|Add the order line metadata for pickup points to the list of hidden meta data.|
|[add_pickup_point_to_rate](#pickuppointsadd_pickup_point_to_rate)|{@inheritDoc}|
|[get_container](#pickuppointsget_container)|{@inheritDoc}|
|[get_pickup_point_from_rate_by_id](#pickuppointsget_pickup_point_from_rate_by_id)|{@inheritDoc}|
|[get_pickup_points_from_rate](#pickuppointsget_pickup_points_from_rate)|{@inheritDoc}|
|[get_selected_pickup_point_from_rate](#pickuppointsget_selected_pickup_point_from_rate)|{@inheritDoc}|
|[init](#pickuppointsinit)|Initialize the class instance.|
|[json_to_array](#pickuppointsjson_to_array)|Convert a JSON string to an array.|
|[remove_pickup_point_from_rate](#pickuppointsremove_pickup_point_from_rate)|{@inheritDoc}|
|[save_pickup_points_to_rate](#pickuppointssave_pickup_points_to_rate)|{@inheritDoc}|
|[save_selected_pickup_point_to_rate](#pickuppointssave_selected_pickup_point_to_rate)|{@inheritDoc}|
|[to_array](#pickuppointsto_array)|Convert an object to an array.|
|[to_json](#pickuppointsto_json)|Convert an array to a JSON string.|




### PickupPoints::__construct  

**Description**

```php
public __construct (bool $add_select_box)
```

Class constructor. 

 

**Parameters**

* `(bool) $add_select_box`
: Whether or not to add the pickup point select box to the checkout page.  

**Return Values**

`void`




<hr />


### PickupPoints::add_hidden_order_itemmeta  

**Description**

```php
public add_hidden_order_itemmeta (array $hidden_order_itemmeta)
```

Add the order line metadata for pickup points to the list of hidden meta data. 

 

**Parameters**

* `(array) $hidden_order_itemmeta`
: The list of hidden meta data.  

**Return Values**

`array`




<hr />


### PickupPoints::add_pickup_point_to_rate  

**Description**

```php
public add_pickup_point_to_rate (void)
```

{@inheritDoc} 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


<hr />


### PickupPoints::get_container  

**Description**

```php
public get_container (void)
```

{@inheritDoc} 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


<hr />


### PickupPoints::get_pickup_point_from_rate_by_id  

**Description**

```php
public get_pickup_point_from_rate_by_id (void)
```

{@inheritDoc} 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


<hr />


### PickupPoints::get_pickup_points_from_rate  

**Description**

```php
public get_pickup_points_from_rate (void)
```

{@inheritDoc} 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


<hr />


### PickupPoints::get_selected_pickup_point_from_rate  

**Description**

```php
public get_selected_pickup_point_from_rate (void)
```

{@inheritDoc} 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


<hr />


### PickupPoints::init  

**Description**

```php
public init (bool $add_select_box)
```

Initialize the class instance. 

 

**Parameters**

* `(bool) $add_select_box`
: Whether or not to add the pickup point select box to the checkout page.  

**Return Values**

`void`




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


### PickupPoints::remove_pickup_point_from_rate  

**Description**

```php
public remove_pickup_point_from_rate (void)
```

{@inheritDoc} 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


<hr />


### PickupPoints::save_pickup_points_to_rate  

**Description**

```php
public save_pickup_points_to_rate (void)
```

{@inheritDoc} 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


<hr />


### PickupPoints::save_selected_pickup_point_to_rate  

**Description**

```php
public save_selected_pickup_point_to_rate (void)
```

{@inheritDoc} 

 

**Parameters**

`This function has no parameters.`

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


### PickupPoints::to_json  

**Description**

```php
public to_json (array|object $item)
```

Convert an array to a JSON string. 

 

**Parameters**

* `(array|object) $item`
: The item to convert to a json string.  

**Return Values**

`string`




<hr />

