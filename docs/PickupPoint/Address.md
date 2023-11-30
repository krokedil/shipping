# Krokedil\Shipping\PickupPoint\Address  

Contains the address for the location of a pickup point.





## Methods

| Name | Description |
|------|-------------|
|[__construct](#address__construct)|PickupPointAddress constructor. Sets the street, city, postcode and country properties for the pickup point address.|
|[get_city](#addressget_city)|Get city.|
|[get_country](#addressget_country)|Get country.|
|[get_postcode](#addressget_postcode)|Get postcode.|
|[get_street](#addressget_street)|Get street.|
|[json_to_array](#addressjson_to_array)|Convert a JSON string to an array.|
|[set_city](#addressset_city)|Set city.|
|[set_country](#addressset_country)|Set country.|
|[set_postcode](#addressset_postcode)|Set postcode.|
|[set_street](#addressset_street)|Set street.|
|[to_array](#addressto_array)|Convert an object to an array.|
|[to_json](#addressto_json)|Convert an array to a JSON string.|




### Address::__construct  

**Description**

```php
public __construct (string|null $street, string|null $city, string|null $postcode, string|null $country)
```

PickupPointAddress constructor. Sets the street, city, postcode and country properties for the pickup point address. 

 

**Parameters**

* `(string|null) $street`
: Street.  
* `(string|null) $city`
: City.  
* `(string|null) $postcode`
: Postcode.  
* `(string|null) $country`
: Country.  

**Return Values**

`void`




<hr />


### Address::get_city  

**Description**

```php
public get_city (void)
```

Get city. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### Address::get_country  

**Description**

```php
public get_country (void)
```

Get country. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### Address::get_postcode  

**Description**

```php
public get_postcode (void)
```

Get postcode. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### Address::get_street  

**Description**

```php
public get_street (void)
```

Get street. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### Address::json_to_array  

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


### Address::set_city  

**Description**

```php
public set_city (string|null $city)
```

Set city. 

 

**Parameters**

* `(string|null) $city`
: City.  

**Return Values**

`void`


<hr />


### Address::set_country  

**Description**

```php
public set_country (string|null $country)
```

Set country. 

 

**Parameters**

* `(string|null) $country`
: Country.  

**Return Values**

`void`


<hr />


### Address::set_postcode  

**Description**

```php
public set_postcode (string|null $postcode)
```

Set postcode. 

 

**Parameters**

* `(string|null) $postcode`
: Postcode.  

**Return Values**

`void`


<hr />


### Address::set_street  

**Description**

```php
public set_street (string|null $street)
```

Set street. 

 

**Parameters**

* `(string|null) $street`
: Street.  

**Return Values**

`void`


<hr />


### Address::to_array  

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


### Address::to_json  

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

