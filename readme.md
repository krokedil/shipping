# Krokedil Shipping Extensions for WooCommerce

## Description.
This package offers a set of shipping extensions for WooCommerce from Krokedil that can be used to provide things like Pickup points for shipping locations in a standardised way.

Right now the package only offers pickup points, but more shipping extensions will be added in the future as they are developed.
You can find a full documentation of the packages classes and methods in the [docs](docs) folder.

## Installation.
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

## Usage.
The package is built to be used by WordPress plugins that works with WooCommerce shipping methods and rates.
To add pickup points to the shipping rates for the customer you need to get them from some source, for example an API, provided by a shipping provider.

It is recommended to create a instance of the service for PickupPoints somewhere that can be accessed from anywhere you want to use it. For example in the initialization of your plugin or in a dependency container.

#### Register pickup points to rates.
When you want to add pickup points to a shipping rate in WooCommerce you can do so by using a instance of the PickupPoints instance you should have created, or create a new instance of the service class.

Then you can simply call the `add_pickup_point_to_rate` method on the service class and pass in the shipping rate and the pickup point that you want to add to the rate.
Keep in mind that for this to work it has to be done during the time the shipping rates are calculated, else they wont be saved to the WooCommerce session data properly. And you will have to manually handle those cases.
```php
// Get the shipping rates from the WooCommerce cart.
$shipping_packages = WC()->shipping->get_packages();
$pickup_points_service = new Krokedil\Shipping\PickupPoints();

foreach( $shipping_packages as $shipping_package ) {
    foreach( $shipping_package['rates'] as $rate ) {
        // Create a new instance of the Krokedil\Shipping\PickupPoint class for each pickup point that you want to add to the rate.
        $pickup_point = new Krokedil\Shipping\PickupPoint();

        // Set the pickup point properties that you need.
        $pickup_point->set_id( '123' );
        $pickup_point->set_name( 'My Pickup Point' );
        $pickup_point->set_address( 'Pickup Point Street 1', 'Pickup Point City', '12345',  'SE' );
        ...

        // Add the pickup point to the rate. This will automatically save it to the rates meta data in the WooCommerce session. Which can then be used by the shipping method to display the pickup points to the customer.
        $pickup_points_service->add_pickup_point_to_rate( $rate, $pickup_point );
    }
}
```

#### Get pickup points from rates.
To retrieve any pickup points from a rate you can do that easily by calling the `get_pickup_points_from_rate` method in the service class and pass it the rate you want to use.

```php
<?php
// Get the shipping rate that you wish to use, either through the cart, or using the hook 'woocommerce_package_rates' or similar, then create an instance of the Krokedil\Shipping\PickupPoints class using the rate.
$pickup_points_service = new Krokedil\Shipping\PickupPoints();
$rate = // Get the rate somehow from the cart or order.

// You can get them using the get_pickup_points_from_rate() method passing the rate to it.
$pickup_points = $pickup_points_service->get_pickup_points_from_rate( $rate );

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
Or for a select field, you can pass a true value to the pickup point service to automatically have it created for you for any shipping methods that have pickup points.
```php
<?php
new Krokedil\Shipping\PickupPoints( true );
```

This will also handle the saving of the selected pickup point to the rate automatically when a change happens in the select field.

### Adding selected pickup point to the rate.
When the customer has selected a pickup point you can add that to the rate by using the `save_selected_pickup_point_to_rate()` method on the service class and pass it the rate and the pickup point that the customer has selected.

This will be automatically saved to the session data for the rate and can then be used by the shipping method to retrieve the selected pickup point. This can be done at any time, since if it happens outside of the normal shipping calculations, we will trigger a recalculation of the shipping rates to ensure that the data is saved properly.
```php
// Get the shipping rate that you wish to use, either through the cart, or using the hook 'woocommerce_package_rates' or similar, then create an instance of the Krokedil\Shipping\PickupPoints class using the rate.
$pickup_points_service = new Krokedil\Shipping\PickupPoints();
$rate = // Get the rate somehow from the cart

// Get the pickup point that the customer has selected.
$pickup_point_id = $_POST['pickup_point'];
$pickup_point = $pickup_points_service->get_pickup_point_from_rate_by_id( $rate, $pickup_point_id );

// Save the pickup point to the rate.
$pickup_points_service->save_selected_pickup_point_to_rate( $rate, $pickup_point );
```

#### Add custom data as metadata to pickup points.
You can add custom data to the pickup points by using the `add_meta_data()` method. This can be used to add data that you need to use for your pickup point that might be unique to your needs, and don't have any other field for it.
```php
$pickup_point->add_meta_data( 'meta_key', 'My custom data' );
```

This can then be retrieved using the `get_meta_data()` method and be used whenever you need it.
```php
$meta_data = $pickup_point->get_meta_data( 'meta_key' );
```
