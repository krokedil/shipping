# Krokedil\Shipping\PickupPoint\EstimatedTimeOfArrival  

Contains the estimated time of arrival for the pickup point location.

Both in UTC and local time.  





## Methods

| Name | Description |
|------|-------------|
|[__construct](#estimatedtimeofarrival__construct)|EstimatedTimeOfArrival constructor. Sets the UTC and local time properties for the pickup points estimated time of arrival.|
|[get_local](#estimatedtimeofarrivalget_local)|Get local time.|
|[get_utc](#estimatedtimeofarrivalget_utc)|Get UTC.|
|[json_to_array](#estimatedtimeofarrivaljson_to_array)|Convert a JSON string to an array.|
|[set_local](#estimatedtimeofarrivalset_local)|Set local time.|
|[set_utc](#estimatedtimeofarrivalset_utc)|Set UTC.|
|[to_array](#estimatedtimeofarrivalto_array)|Convert an object to an array.|
|[to_json](#estimatedtimeofarrivalto_json)|Convert an array to a JSON string.|




### EstimatedTimeOfArrival::__construct  

**Description**

```php
public __construct (string|null $utc, string|null $local)
```

EstimatedTimeOfArrival constructor. Sets the UTC and local time properties for the pickup points estimated time of arrival. 

 

**Parameters**

* `(string|null) $utc`
: UTC.  
* `(string|null) $local`
: Local time.  

**Return Values**

`void`




<hr />


### EstimatedTimeOfArrival::get_local  

**Description**

```php
public get_local (void)
```

Get local time. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### EstimatedTimeOfArrival::get_utc  

**Description**

```php
public get_utc (void)
```

Get UTC. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### EstimatedTimeOfArrival::json_to_array  

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


### EstimatedTimeOfArrival::set_local  

**Description**

```php
public set_local (string|null $local)
```

Set local time. 

 

**Parameters**

* `(string|null) $local`
: Local time.  

**Return Values**

`void`


<hr />


### EstimatedTimeOfArrival::set_utc  

**Description**

```php
public set_utc (string|null $utc)
```

Set UTC. 

 

**Parameters**

* `(string|null) $utc`
: UTC.  

**Return Values**

`void`


<hr />


### EstimatedTimeOfArrival::to_array  

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


### EstimatedTimeOfArrival::to_json  

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

