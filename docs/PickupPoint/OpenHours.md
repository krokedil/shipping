# Krokedil\Shipping\PickupPoint\OpenHours  

Contains the open hours for the pickup point location for a specific day.





## Methods

| Name | Description |
|------|-------------|
|[__construct](#openhours__construct)|OpenHours constructor. Sets the day, open and close properties.|
|[get_close](#openhoursget_close)|Get close.|
|[get_day](#openhoursget_day)|Get day.|
|[get_open](#openhoursget_open)|Get open.|
|[json_to_array](#openhoursjson_to_array)|Convert a JSON string to an array.|
|[set_close](#openhoursset_close)|Set close.|
|[set_day](#openhoursset_day)|Set day.|
|[set_open](#openhoursset_open)|Set open.|
|[to_array](#openhoursto_array)|Convert an object to an array.|
|[to_json](#openhoursto_json)|Convert an array to a JSON string.|




### OpenHours::__construct  

**Description**

```php
public __construct (string|null $day, string|null $open, string|null $close)
```

OpenHours constructor. Sets the day, open and close properties. 

 

**Parameters**

* `(string|null) $day`
: Day.  
* `(string|null) $open`
: Open.  
* `(string|null) $close`
: Close.  

**Return Values**

`void`




<hr />


### OpenHours::get_close  

**Description**

```php
public get_close (void)
```

Get close. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### OpenHours::get_day  

**Description**

```php
public get_day (void)
```

Get day. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### OpenHours::get_open  

**Description**

```php
public get_open (void)
```

Get open. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### OpenHours::json_to_array  

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


### OpenHours::set_close  

**Description**

```php
public set_close (string|null $close)
```

Set close. 

 

**Parameters**

* `(string|null) $close`
: Close.  

**Return Values**

`void`


<hr />


### OpenHours::set_day  

**Description**

```php
public set_day (string|null $day)
```

Set day. 

 

**Parameters**

* `(string|null) $day`
: Day.  

**Return Values**

`void`


<hr />


### OpenHours::set_open  

**Description**

```php
public set_open (string|null $open)
```

Set open. 

 

**Parameters**

* `(string|null) $open`
: Open.  

**Return Values**

`void`


<hr />


### OpenHours::to_array  

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


### OpenHours::to_json  

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

