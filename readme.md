# Krokedil Shipping Extensions for WooCommerce

## Description
This package offers a set of shipping extensions for WooCommerce from Krokedil that can be used to provide things like Pickup points for shipping locations in a standardised way.

Right now the package only offers pickup points, but more shipping extensions will be added in the future as they are developed.
You can find a full documentation of the packages classes and methods in the [docs](docs) folder.

## Installation
You need to add the following to your `composer.json` file to ensure that the package is installed from the correct repository from Github:
```json
"repositories": [
    {
        "type": "vcs",
        "url": "git@github.com:krokedil/shipping.git"
    }
]

```
Then the package can be installed via composer using the cli:
```bash
composer require krokedil/shipping
```

Or you can add it as a dependency to your `composer.json` file:
```json
"require": {
    "krokedil/shipping": "^1.0"
}
```

## Usage
The package is built to be used by WordPress plugins that works with WooCommerce shipping methods and rates.
To add pickup points to the shipping rates for the customer you need to get them from some source, for example an API, provided by a shipping provider.

#### Register pickup points to rates
When you want to add pickup points to shipping rates create a new instance of the Krokedil\Shipping\PickupPoints class, and pass the rate as a parameter to the constructor.
Then you can add pickup points to the rate by using the `add_pickup_point()` method. You will need to get the data for the pickup points from some source, or hardcode it if you want to.
```php
// Get the shipping rates from the WooCommerce cart.
$shipping_packages = WC()->shipping->get_packages();

foreach( $shipping_packages as $shipping_package ) {
    foreach( $shipping_package['rates'] as $rate ) {
        // Create a new instance of the Krokedil\Shipping\PickupPoints class.
        $pickup_points = new Krokedil\Shipping\PickupPoints( $rate );

        // Create a new instance of the Krokedil\Shipping\PickupPoint class for each pickup point that you want to add to the rate.
        $pickup_point = new Krokedil\Shipping\PickupPoint();

        // Set the pickup point properties that you need.
        $pickup_point->set_id( '123' );
        $pickup_point->set_name( 'My Pickup Point' );
        $pickup_point->set_address( 'Pickup Point Street 1', 'Pickup Point City', '12345',  'SE' );
        ...

        // Add pickup points to the rate. This will automatically save it to the rates meta data in the WooCommerce session. Which can then be used by the shipping method to display the pickup points to the customer.
        $pickup_points->add_pickup_point( $pickup_point );
    }
}
```

#### Get pickup points from rates
When you want to get the pickup points from the shipping rate you can use the `get_pickup_points()` method. This example will show a simple way to get the pickup points from the rate and display them to the customer using a select field.
```php
<?php
// Get the shipping rate that you wish to use, either through the cart, or using the hook 'woocommerce_package_rates' or similar, then create an instance of the Krokedil\Shipping\PickupPoints class using the rate.
$pickup_points = new Krokedil\Shipping\PickupPoints( $rate );

// If the rate has pickup points, you can get them using the get_pickup_points() method, since they will automatically be retrieved by the class when it is instantiated.
$pickup_points = $pickup_points->get_pickup_points();

echo '<select name="pickup_point">';
echo '<option value="">Select pickup point</option>'
// You can then loop through the pickup points and get the data that you need.
foreach( $pickup_points as $pickup_point ) {
    $id = $pickup_point->get_id();
    $name = $pickup_point->get_name();
    $street = $pickup_point->get_address()->get_street();
    $city = $pickup_point->get_address()->get_city();
    $postcode = $pickup_point->get_address()->get_postcode();
    ...

    // Use the data to display the pickup points to the customer, or whatever else you need it for.
    echo "<option value='$id' data-street='$street' data-city='$city' data-postcode='$postcode'>$name</option>";
}
echo '</select>';
```

#### Add custom data as metadata to pickup points
You can add custom data to the pickup points by using the `add_meta_data()` method. This can be used to add data that you need to use for your pickup point that might be unique to your needs, and dont have any other field for it.
```php
$pickup_point->add_meta_data( 'meta_key', 'My custom data' );
```

This can then be retrieved using the `get_meta_data()` method and be used whenever you need it.
```php
$meta_data = $pickup_point->get_meta_data( 'meta_key' );
```
