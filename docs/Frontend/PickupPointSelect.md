# Krokedil\Shipping\Frontend\PickupPointSelect  

Class PickupPointSelect

Handles the rendering and logic of the pickup point select box on the checkout page.  





## Methods

| Name | Description |
|------|-------------|
|[__construct](#pickuppointselect__construct)|Class constructor.|
|[render](#pickuppointselectrender)|Render the pickup point select box.|
|[set_selected_pickup_point](#pickuppointselectset_selected_pickup_point)|Set the selected pickup point for the shipping method.|
|[set_selected_pickup_point_ajax](#pickuppointselectset_selected_pickup_point_ajax)|Ajax callback handler to set the selected pickup point for the shipping method.|




### PickupPointSelect::__construct  

**Description**

```php
public __construct (\PickupPointServiceInterface $pickup_point_service)
```

Class constructor. 

 

**Parameters**

* `(\PickupPointServiceInterface) $pickup_point_service`

**Return Values**

`void`




<hr />


### PickupPointSelect::render  

**Description**

```php
public render (\WC_Shipping_Rate $shipping_rate)
```

Render the pickup point select box. 

 

**Parameters**

* `(\WC_Shipping_Rate) $shipping_rate`
: WooCommerce shipping rate instance.  

**Return Values**

`void`




<hr />


### PickupPointSelect::set_selected_pickup_point  

**Description**

```php
public set_selected_pickup_point (string $pickup_point_id, string $rate_id)
```

Set the selected pickup point for the shipping method. 

Returns a WP_Error if something went wrong. Otherwise true. 

**Parameters**

* `(string) $pickup_point_id`
: The id of the selected pickup point.  
* `(string) $rate_id`
: The id of the shipping rate.  

**Return Values**

`\WP_Error|bool`




<hr />


### PickupPointSelect::set_selected_pickup_point_ajax  

**Description**

```php
public set_selected_pickup_point_ajax (void)
```

Ajax callback handler to set the selected pickup point for the shipping method. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`




<hr />

