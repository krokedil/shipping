# Changelog

All notable changes of krokedil/shipping are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

------------------

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
