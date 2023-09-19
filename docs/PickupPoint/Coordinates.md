# Krokedil\Shipping\PickupPoint\Coordinates  

Contains the coordinates for the location of a pickup point.





## Methods

| Name | Description |
|------|-------------|
|[__construct](#coordinates__construct)|Coordinates constructor. Sets the latitude and longitude properties.|
|[array_to_json](#coordinatesarray_to_json)|Convert an array to a JSON string.|
|[get_latitude](#coordinatesget_latitude)|Get latitude.|
|[get_longitude](#coordinatesget_longitude)|Get longitude.|
|[json_to_array](#coordinatesjson_to_array)|Convert a JSON string to an array.|
|[set_latitude](#coordinatesset_latitude)|Set latitude.|
|[set_longitude](#coordinatesset_longitude)|Set longitude.|
|[to_array](#coordinatesto_array)|Convert an object to an array.|




### Coordinates::__construct  

**Description**

```php
public __construct (float|string|null $latitude, float|string|null $longitude)
```

Coordinates constructor. Sets the latitude and longitude properties. 

Latitude and longitude are floats.  
If no latitude or longitude is provided, the default value is 0.0. 

**Parameters**

* `(float|string|null) $latitude`
: Latitude.  
* `(float|string|null) $longitude`
: Longitude.  

**Return Values**

`void`




<hr />


### Coordinates::array_to_json  

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


### Coordinates::get_latitude  

**Description**

```php
public get_latitude (void)
```

Get latitude. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`float`




<hr />


### Coordinates::get_longitude  

**Description**

```php
public get_longitude (void)
```

Get longitude. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`float`




<hr />


### Coordinates::json_to_array  

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


### Coordinates::set_latitude  

**Description**

```php
public set_latitude (float|string|null $latitude)
```

Set latitude. 

 

**Parameters**

* `(float|string|null) $latitude`
: Latitude.  

**Return Values**

`void`


<hr />


### Coordinates::set_longitude  

**Description**

```php
public set_longitude (float|string|null $longitude)
```

Set longitude. 

 

**Parameters**

* `(float|string|null) $longitude`
: Longitude.  

**Return Values**

`void`


<hr />


### Coordinates::to_array  

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

