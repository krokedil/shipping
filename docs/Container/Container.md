# Krokedil\Shipping\Container\Container  

Class Container

Handles the dependency injection for the package.  

## Implements:
Psr\Container\ContainerInterface



## Methods

| Name | Description |
|------|-------------|
|[add](#containeradd)|Add a entry to the container.|
|[get](#containerget)|{@inheritDoc}|
|[get_instance](#containerget_instance)|Get the class instance.|
|[has](#containerhas)|{@inheritDoc}|




### Container::add  

**Description**

```php
public add (string $name, mixed $service)
```

Add a entry to the container. 

 

**Parameters**

* `(string) $name`
: The name of the entry to add to the container.  
* `(mixed) $service`
: The entry to add to the container.  

**Return Values**

`void`




<hr />


### Container::get  

**Description**

```php
public get (void)
```

{@inheritDoc} 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


<hr />


### Container::get_instance  

**Description**

```php
public static get_instance (void)
```

Get the class instance. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`\Container`




<hr />


### Container::has  

**Description**

```php
public has (void)
```

{@inheritDoc} 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


<hr />

