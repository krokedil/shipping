# Krokedil\Shipping\Ajax\AjaxRequest  

Class AjaxRequest

Defines a single AJAX request and how to process it.  





## Methods

| Name | Description |
|------|-------------|
|[__construct](#ajaxrequest__construct)|Class constructor.|
|[get_action](#ajaxrequestget_action)|Get the name of the AJAX action.|
|[get_callback](#ajaxrequestget_callback)|Get the callback function to process the AJAX request.|
|[get_no_priv](#ajaxrequestget_no_priv)|Get if the AJAX request requires a logged in user.|
|[process](#ajaxrequestprocess)|Process the AJAX request.|




### AjaxRequest::__construct  

**Description**

```php
public __construct (string $action, callable $callback, bool $no_priv)
```

Class constructor. 

 

**Parameters**

* `(string) $action`
* `(callable) $callback`
* `(bool) $no_priv`

**Return Values**

`void`




<hr />


### AjaxRequest::get_action  

**Description**

```php
public get_action (void)
```

Get the name of the AJAX action. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`




<hr />


### AjaxRequest::get_callback  

**Description**

```php
public get_callback (void)
```

Get the callback function to process the AJAX request. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`callable`




<hr />


### AjaxRequest::get_no_priv  

**Description**

```php
public get_no_priv (void)
```

Get if the AJAX request requires a logged in user. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`bool`




<hr />


### AjaxRequest::process  

**Description**

```php
public process (void)
```

Process the AJAX request. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`




<hr />

