# Krokedil\Shipping\Interfaces\PickupPointServiceInterface  

Interface PickupPointServiceInterface





## Methods

| Name | Description |
|------|-------------|
|[add_pickup_point_to_rate](#pickuppointserviceinterfaceadd_pickup_point_to_rate)|Add a pickup point to the rate.|
|[get_container](#pickuppointserviceinterfaceget_container)|Retrieve the container that holds all the registered services for the pickup point service.|
|[get_pickup_point_from_rate_by_id](#pickuppointserviceinterfaceget_pickup_point_from_rate_by_id)|Get a pickup point from a rate by id.|
|[get_pickup_points_from_rate](#pickuppointserviceinterfaceget_pickup_points_from_rate)|Get the pickup points for a specific rate.|
|[get_selected_pickup_point_from_rate](#pickuppointserviceinterfaceget_selected_pickup_point_from_rate)|Get the selected pickup point for a specific rate. If no pickup point is selected, returns false.|
|[remove_pickup_point_from_rate](#pickuppointserviceinterfaceremove_pickup_point_from_rate)|Remove a pickup point from the rate.|
|[save_pickup_points_to_rate](#pickuppointserviceinterfacesave_pickup_points_to_rate)|Save the pickup points for a specific rate.|
|[save_selected_pickup_point_to_rate](#pickuppointserviceinterfacesave_selected_pickup_point_to_rate)|Save the selected pickup point for a specific rate.|




### PickupPointServiceInterface::add_pickup_point_to_rate  

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


### PickupPointServiceInterface::get_container  

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


### PickupPointServiceInterface::get_pickup_point_from_rate_by_id  

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


### PickupPointServiceInterface::get_pickup_points_from_rate  

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


### PickupPointServiceInterface::get_selected_pickup_point_from_rate  

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


### PickupPointServiceInterface::remove_pickup_point_from_rate  

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


### PickupPointServiceInterface::save_pickup_points_to_rate  

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


### PickupPointServiceInterface::save_selected_pickup_point_to_rate  

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

