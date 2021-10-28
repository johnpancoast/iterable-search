<?php
/**
 * @package       johnpancoast/data-processor
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace YourNamespace;

use JMS\Serializer\Annotation as JMS;

/**
 * @author John Pancoast <johnpancoast.tech@gmail.com>
 *
 * @see animals.csv
 * @JMS\ExclusionPolicy("all")
 */
class Animal
{
    /**
     * @var int
     * @JMS\Expose
     * @JMS\Type("int")
     */
    public $id;

    /**
     * @var string
     * @JMS\Expose
     * @JMS\Type("string")
     */
    public $title;

    /**
     * @var string
     *
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\SerializedName("sound")
     */
    public $sound;
}
