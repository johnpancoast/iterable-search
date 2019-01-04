<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\IterableParser\DataProvider;

use Pancoast\IterableParser\DataProviderInterface;
use Pancoast\IterableParser\DataProviderTrait;

/**
 * File provider
 *
 * Note that this gives us the ability to iterate file data while still sticking to our contracts
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class FileProvider extends \SplFileObject implements DataProviderInterface
{
    use DataProviderTrait;
}
