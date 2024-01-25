# Krokedil\Shipping\Ajax\AjaxRegistry  

Class AjaxRegistry

Handles the registration of AJAX requests.  





## Methods

| Name | Description |
|------|-------------|
|[__construct](#ajaxregistry__construct)|Class constructor.|
|[add_request](#ajaxregistryadd_request)|Add an AJAX request to the registry.|
|[get_request](#ajaxregistryget_request)|Get an AJAX request from the registry.|
|[register_requests](#ajaxregistryregister_requests)|Register the AJAX requests.|




### AjaxRegistry::__construct  

**Description**

```php
public __construct (void)
```

Class constructor. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`




<hr />


### AjaxRegistry::add_request  

**Description**

```php
public add_request (\AjaxRequest $request)
```

Add an AJAX request to the registry. 

 

**Parameters**

* `(\AjaxRequest) $request`

**Return Values**

`void`




<hr />


### AjaxRegistry::get_request  

**Description**

```php
public get_request (string $action)
```

Get an AJAX request from the registry. 

 

**Parameters**

* `(string) $action`

**Return Values**

`\AjaxRequest|null`




<hr />


### AjaxRegistry::register_requests  

**Description**

```php
public register_requests (void)
```

Register the AJAX requests. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`




<hr />

