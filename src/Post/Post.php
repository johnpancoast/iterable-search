<?php
/**
 * @package       johnpancoast/code-challenge
 * @copyright (c) 2016 John Pancoast
 * @license       Public Domain
 */

namespace Pancoast\CodeChallenge\Post;

use JMS\Serializer\Annotation as JMS;
use Pancoast\CodeChallenge\Util;

/**
 * A post
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 *
 * @JMS\ExclusionPolicy("all")
 */
class Post
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
     * @var bool
     *
     * Note that our internal property value and th serialized value will value will differ.
     * See the Accessor annotation below, and the methods specified, for details.
     *
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\SerializedName("privacy")
     */
    public $privacy;

    /**
     * @var int
     * @JMS\Expose
     * @JMS\Type("int")
     */
    public $likes;

    /**
     * @var int
     * @JMS\Expose
     * @JMS\Type("int")
     */
    public $views;

    /**
     * @var int
     * @JMS\Expose
     * @JMS\Type("int")
     */
    public $comments;

    /**
     * @var \DateTime
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\Accessor(setter="setTimestampFromString", getter="getTimestampAsString")
     */
    public $timestamp;

    /**
     * Get private
     *
     * @return boolean
     */
    public function isPrivate()
    {
        return $this->privacy == 'private' ? true : false;
    }
}
