<?php
namespace Krokedil\Shipping\Container\Exceptions;

use Psr\Container\NotFoundExceptionInterface;

/**
 * Class ContainerException
 *
 * Handles the exception thrown when a service is not found in the container.
 */
class ContainerException extends \Exception implements NotFoundExceptionInterface {
}
