# Changelog

All notable changes of krokedil/shipping are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]
### Added
* Added support for setting the shipping carrier to the rate using the ShippingRate class.

------------------
## [2.3.2] - 2025-10-14

### Fixed
* Add array as default value to chosen_shipping_methods in render pickup point selector method to avoid PHP errors.

## [2.3.1] - 2025-09-16

### Fixed
* Fixed an incorrect if statement when testing if the shipping method should be verified in the SessionHandler class.

## [2.3.0] - 2025-07-16

### Added
* Added a improved error handling for shipping methods that have been changed during the checkout process. If the shipping package is used, instead of letting WooCommerce set the first shipping method, it will now throw an error that stops the checkout process and informs the customer that the shipping methods have changed. This has to be enabled with the filter `krokedil_shipping_should_verify_shipping` which is set to false by default to prevent unwanted behavior in existing setups.
* Added a filter `krokedil_shipping_changed_auto_correct` to allow developers to auto-correct the shipping method if it has been changed during the checkout process. This is useful if you want to automatically set the shipping method to the first available one instead of throwing an error. However this is not recommended as it can lead to unexpected issues if the chosen method is no longer available.
* Added a filter `krokedil_shipping_changed_throw_error` to allow merchants or plugins to disable the error handling for shipping methods that have been changed during the checkout process. This is useful if you want to handle the error in your own way, or if you want to disable the error handling completely, for example for specific payment or shipping methods.

### Fixed
* Fixed an issue where the shipping methods selected pickup point would be reset in some cases when the shipping methods were recalculated.

## [2.2.0] - 2025-06-09

### Added
* Added a metabox to show the pickup point and shipping information on the edit order page.
* Added support for showing hidden order line metadata on shipping lines with pickup points when adding the query tag "debug".
* Added functionality to add descriptions to shipping methods that are saved to the shipping rate as `krokedil_description` metadata.

### Fixed
* Fixed an issue with not properly setting the selected pickup point to the first option if none are selected when calculating shipping methods.

### Changed
* The pickup point information is now decoded using `html_entity_decode`.

## [2.1.0] - 2024-01-30

### Added
* Added a PSR 11 container for the dependencies of the package.
* Added a Asset handling to register frontend assets
* Added a Ajax handling to handle events from frontend.
* Added a SessionHandler that handles all communication with the WooCommerce session. This lets us update the shipping rates in the checkout whenever we need, and no longer are reliant on the WooCommerce session to update the rates.
* Added functionality to display the pickup points in the checkout from the package directly. It will also handle updating the rate when a pickup point is selected.

## [2.0.0] - 2023-10-06

### Added
* Added a field for the Selected pickup point in the PickupPoints object. Along with getters and setters for them using the PickupPoint id or the PickupPoint object directly.

### Changed
* The method arrayToJson has been renamed to toJson. This is a breaking change if you have used the method in your code.
* Heavily simplified the way the PickupPoints class is being implemented, and how it is used. It is no longer a model itself but rather a service to build an array of PickupPoint objects. This is a breaking change if you have used the class in your code.

---

## [1.0.0] - 2023-09-19

### Added

* Initial release of the package.
