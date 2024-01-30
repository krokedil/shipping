# Krokedil\Shipping\PickupPoint\PickupPoint  

Contains the data for a pickup point.





## Methods

| Name | Description |
|------|-------------|
|[__construct](#pickuppoint__construct)|PickupPoint constructor. Can be passed a array or a json string to automatically set the properties.|
|[add_meta_data](#pickuppointadd_meta_data)|Add meta data to the pickup point.|
|[get_address](#pickuppointget_address)|Get the address.|
|[get_coordinates](#pickuppointget_coordinates)|Get the coordinates.|
|[get_description](#pickuppointget_description)|Get the description.|
|[get_eta](#pickuppointget_eta)|Get the estimated time of arrival.|
|[get_id](#pickuppointget_id)|Get the ID.|
|[get_meta_data](#pickuppointget_meta_data)|Get the meta data.|
|[get_name](#pickuppointget_name)|Get the name.|
|[get_open_hours](#pickuppointget_open_hours)|Get the opening hours.|
|[json_to_array](#pickuppointjson_to_array)|Convert a JSON string to an array.|
|[set_address](#pickuppointset_address)|Set the address.|
|[set_coordinates](#pickuppointset_coordinates)|Set the coordinates.|
|[set_description](#pickuppointset_description)|Set the description.|
|[set_eta](#pickuppointset_eta)|Set the estimated time of arrival.|
|[set_from_array](#pickuppointset_from_array)|Set the pickup point from an array.|
|[set_id](#pickuppointset_id)|Set the ID.|
|[set_name](#pickuppointset_name)|Set the name.|
|[set_open_hour](#pickuppointset_open_hour)|Set a single opening hour for a specific day.|
|[set_open_hours](#pickuppointset_open_hours)|Set the opening hours.|
|[to_array](#pickuppointto_array)|Convert an object to an array.|
|[to_json](#pickuppointto_json)|Convert an array to a JSON string.|




### PickupPoint::__construct  

**Description**

```php
public __construct (array|string $pickup_point)
```

PickupPoint constructor. Can be passed a array or a json string to automatically set the properties. 

If a string is passed it will be json decoded, if a array is passed it will be set directly. 

**Parameters**

* `(array|string) $pickup_point`
: Pickup point data as a array.  

**Return Values**

`void`




<hr />


### PickupPoint::add_meta_data  

**Description**

```php
public add_meta_data (string $key, mixed $value)
```

Add meta data to the pickup point. 

 

**Parameters**

* `(string) $key`
: The meta key to store the value under.  
* `(mixed) $value`
: The meta value to store.  

**Return Values**

`void`


<hr />


### PickupPoint::get_address  

**Description**

```php
public get_address (void)
```

Get the address. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\Address`




<hr />


### PickupPoint::get_coordinates  

**Description**

```php
public get_coordinates (void)
```

Get the coordinates. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\Coordinates`




<hr />


### PickupPoint::get_description  

**Description**

```php
public get_description (void)
```

Get the description. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### PickupPoint::get_eta  

**Description**

```php
public get_eta (void)
```

Get the estimated time of arrival. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\EstimatedTimeOfArrival`




<hr />


### PickupPoint::get_id  

**Description**

```php
public get_id (void)
```

Get the ID. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### PickupPoint::get_meta_data  

**Description**

```php
public get_meta_data (string $key)
```

Get the meta data. 

 

**Parameters**

* `(string) $key`
: The meta key to get the value for.  

**Return Values**

`mixed|false`




<hr />


### PickupPoint::get_name  

**Description**

```php
public get_name (void)
```

Get the name. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### PickupPoint::get_open_hours  

**Description**

```php
public get_open_hours (void)
```

Get the opening hours. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\OpenHours[]`




<hr />


### PickupPoint::json_to_array  

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


### PickupPoint::set_address  

**Description**

```php
public set_address (string $street, string $city, string $postcode, string $country)
```

Set the address. 

 

**Parameters**

* `(string) $street`
: Street.  
* `(string) $city`
: City.  
* `(string) $postcode`
: Postcode.  
* `(string) $country`
: Country.  

**Return Values**

`void`


<hr />


### PickupPoint::set_coordinates  

**Description**

```php
public set_coordinates (float|string|null $latitude, float|string|null $longitude)
```

Set the coordinates. 

 

**Parameters**

* `(float|string|null) $latitude`
: Latitude.  
* `(float|string|null) $longitude`
: Longitude.  

**Return Values**

`void`


<hr />


### PickupPoint::set_description  

**Description**

```php
public set_description (string|null $description)
```

Set the description. 

 

**Parameters**

* `(string|null) $description`
: Description.  

**Return Values**

`void`


<hr />


### PickupPoint::set_eta  

**Description**

```php
public set_eta (string|null $utc, string|null $local)
```

Set the estimated time of arrival. 

 

**Parameters**

* `(string|null) $utc`
: UTC.  
* `(string|null) $local`
: Local time.  

**Return Values**

`void`


<hr />


### PickupPoint::set_from_array  

**Description**

```php
public set_from_array (array $pickup_point)
```

Set the pickup point from an array. 

 

**Parameters**

* `(array) $pickup_point`
: Pickup point data as a array.  

**Return Values**

`void`


<hr />


### PickupPoint::set_id  

**Description**

```php
public set_id (string|null $id)
```

Set the ID. 

 

**Parameters**

* `(string|null) $id`
: ID.  

**Return Values**

`void`


<hr />


### PickupPoint::set_name  

**Description**

```php
public set_name (string|null $name)
```

Set the name. 

 

**Parameters**

* `(string|null) $name`
: Name.  

**Return Values**

`void`


<hr />


### PickupPoint::set_open_hour  

**Description**

```php
public set_open_hour (string $day, string $open, string $close)
```

Set a single opening hour for a specific day. 

 

**Parameters**

* `(string) $day`
: Day.  
* `(string) $open`
: Open.  
* `(string) $close`
: Close.  

**Return Values**

`void`


<hr />


### PickupPoint::set_open_hours  

**Description**

```php
public set_open_hours (array $open_hours)
```

Set the opening hours. 

 

**Parameters**

* `(array) $open_hours`
: Opening hours.  

**Return Values**

`void`


<hr />


### PickupPoint::to_array  

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


### PickupPoint::to_json  

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

