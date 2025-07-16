# Krokedil\Shipping\PickupPoints  

Class PickupPoints

Handles the pickup points service and any interaction with WooCommerce that is required for the package to work properly.
Offloading this from the plugins that implement it to a service class.  

## Implements:
Krokedil\Shipping\Interfaces\PickupPointServiceInterface



## Methods

| Name | Description |
|------|-------------|
|[__construct](#pickuppoints__construct)|Class constructor.|
|[add_hidden_order_itemmeta](#pickuppointsadd_hidden_order_itemmeta)|Add the order line metadata for pickup points to the list of hidden meta data.|
|[add_pickup_point_to_rate](#pickuppointsadd_pickup_point_to_rate)|Add a pickup point to the rate.|
|[get_container](#pickuppointsget_container)|Retrieve the container that holds all the registered services for the pickup point service.|
|[get_pickup_point_from_rate_by_id](#pickuppointsget_pickup_point_from_rate_by_id)|Get a pickup point from a rate by id.|
|[get_pickup_points_from_rate](#pickuppointsget_pickup_points_from_rate)|Get the pickup points for a specific rate.|
|[get_selected_pickup_point_from_rate](#pickuppointsget_selected_pickup_point_from_rate)|Get the selected pickup point for a specific rate. If no pickup point is selected, returns false.|
|[get_selected_pickup_point_from_rate_session](#pickuppointsget_selected_pickup_point_from_rate_session)|Get the selected pickup point from the session for a rate.|
|[get_selected_pickup_point_from_session](#pickuppointsget_selected_pickup_point_from_session)|Get the selected pickup point from the session.|
|[get_shipping_lines_from_order](#pickuppointsget_shipping_lines_from_order)|Return any pickup point shipping methods from a WooCommerce order.|
|[init](#pickuppointsinit)|Initialize the class instance.|
|[json_to_array](#pickuppointsjson_to_array)|Convert a JSON string to an array.|
|[remove_pickup_point_from_rate](#pickuppointsremove_pickup_point_from_rate)|Remove a pickup point from the rate.|
|[save_pickup_points_to_rate](#pickuppointssave_pickup_points_to_rate)|Save the pickup points for a specific rate.|
|[save_selected_pickup_point_to_rate](#pickuppointssave_selected_pickup_point_to_rate)|Save the selected pickup point for a specific rate.|
|[save_selected_pickup_point_to_session](#pickuppointssave_selected_pickup_point_to_session)|Save the selected pickup point for a specific rate.|
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
public add_pickup_point_to_rate (\WC_Shipping_Rate $rate, \PickupPoint $pickup_point)
```

Add a pickup point to the rate. 

 

**Parameters**

* `(\WC_Shipping_Rate) $rate`
: The WooCommerce shipping rate to add the pickup point to.  
* `(\PickupPoint) $pickup_point`
: The pickup point to add.  

**Return Values**

`void`




<hr />


### PickupPoints::get_container  

**Description**

```php
public get_container (void)
```

Retrieve the container that holds all the registered services for the pickup point service. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\Container`




<hr />


### PickupPoints::get_pickup_point_from_rate_by_id  

**Description**

```php
public get_pickup_point_from_rate_by_id (\WC_Shipping_Rate $rate, string $id)
```

Get a pickup point from a rate by id. 

 

**Parameters**

* `(\WC_Shipping_Rate) $rate`
: The WooCommerce shipping rate to get the pickup point from.  
* `(string) $id`
: The id of the pickup point to get.  

**Return Values**

`\PickupPoint|null`




<hr />


### PickupPoints::get_pickup_points_from_rate  

**Description**

```php
public get_pickup_points_from_rate (\WC_Shipping_Rate $rate)
```

Get the pickup points for a specific rate. 

 

**Parameters**

* `(\WC_Shipping_Rate) $rate`
: The WooCommerce shipping rate to get the pickup points from.  

**Return Values**

`\PickupPoint[]`




<hr />


### PickupPoints::get_selected_pickup_point_from_rate  

**Description**

```php
public get_selected_pickup_point_from_rate (\WC_Shipping_Rate $rate)
```

Get the selected pickup point for a specific rate. If no pickup point is selected, returns false. 

 

**Parameters**

* `(\WC_Shipping_Rate) $rate`
: The WooCommerce shipping rate to get the selected pickup point from.  

**Return Values**

`\PickupPoint|bool`




<hr />


### PickupPoints::get_selected_pickup_point_from_rate_session  

**Description**

```php
public get_selected_pickup_point_from_rate_session (\WC_Shipping_Rate $rate)
```

Get the selected pickup point from the session for a rate. 

 

**Parameters**

* `(\WC_Shipping_Rate) $rate`
: The WooCommerce shipping rate to get the selected pickup point from.  

**Return Values**

`\PickupPoint|bool`




<hr />


### PickupPoints::get_selected_pickup_point_from_session  

**Description**

```php
public get_selected_pickup_point_from_session (void)
```

Get the selected pickup point from the session. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\PickupPoint|bool`




<hr />


### PickupPoints::get_shipping_lines_from_order  

**Description**

```php
public get_shipping_lines_from_order (\WC_Order $order)
```

Return any pickup point shipping methods from a WooCommerce order. 

 

**Parameters**

* `(\WC_Order) $order`
: The WooCommerce order.  

**Return Values**

`array|bool`




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
public remove_pickup_point_from_rate (\WC_Shipping_Rate $rate, \PickupPoint $pickup_point)
```

Remove a pickup point from the rate. 

 

**Parameters**

* `(\WC_Shipping_Rate) $rate`
: The WooCommerce shipping rate to remove the pickup point from.  
* `(\PickupPoint) $pickup_point`
: The pickup point to remove.  

**Return Values**

`void`




<hr />


### PickupPoints::save_pickup_points_to_rate  

**Description**

```php
public save_pickup_points_to_rate (\WC_Shipping_Rate $rate, \PickupPoint[] $pickup_points)
```

Save the pickup points for a specific rate. 

 

**Parameters**

* `(\WC_Shipping_Rate) $rate`
: The WooCommerce shipping rate to save the pickup points to.  
* `(\PickupPoint[]) $pickup_points`
: The pickup points to save.  

**Return Values**

`void`




<hr />


### PickupPoints::save_selected_pickup_point_to_rate  

**Description**

```php
public save_selected_pickup_point_to_rate (\WC_Shipping_Rate $rate, \PickupPoint $pickup_point)
```

Save the selected pickup point for a specific rate. 

 

**Parameters**

* `(\WC_Shipping_Rate) $rate`
: The WooCommerce shipping rate to save the selected pickup point to.  
* `(\PickupPoint) $pickup_point`
: The pickup point to save.  

**Return Values**

`void`




<hr />


### PickupPoints::save_selected_pickup_point_to_session  

**Description**

```php
public save_selected_pickup_point_to_session (\PickupPoint $pickup_point)
```

Save the selected pickup point for a specific rate. 

 

**Parameters**

* `(\PickupPoint) $pickup_point`
: The pickup point to save.  

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

