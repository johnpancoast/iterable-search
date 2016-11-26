<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\DataProcessor\DataProvider;

use Pancoast\DataProcessor\DataProviderInterface;
use Pancoast\DataProcessor\DataProviderTrait;

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
