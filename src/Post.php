<?php
/**
 * @package       johnpancoast/code-challenge
 * @copyright (c) 2016 John Pancoast
 * @license       Public Domain
 */

namespace Pancoast\CodeChallenge;

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
    private $id;

    /**
     * @var string
     * @JMS\Expose
     * @JMS\Type("string")
     */
    private $title;

    /**
     * @var bool
     *
     * Note that our internal property value and th serialized value will value will differ.
     * See the Accessor annotation below, and the methods specified, for details.
     *
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\SerializedName("privacy")
     * @JMS\Accessor(setter="setPrivacyFromString", getter="getPrivacyAsString")
     */
    private $private;

    /**
     * @var int
     * @JMS\Type("int")
     * @JMS\Expose
     */
    private $likes;

    /**
     * @var int
     * @JMS\Type("int")
     * @JMS\Expose
     */
    private $views;

    /**
     * @var int
     * @JMS\Type("int")
     * @JMS\Expose
     */
    private $comments;

    /**
     * @var \DateTime
     * @JMS\Type("string")
     * @JMS\Expose
     * @JMS\Accessor(setter="setTimestampFromString", getter="getTimestampAsString")
     */
    private $timestamp;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id
     *
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        Util::validateType($id, 'int', '$id');
        $this->id = $id;
        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        Util::validateType($title, 'string', '$title');
        $this->title = $title;
        return $this;
    }

    /**
     * Get private
     *
     * @return boolean
     */
    public function isPrivate()
    {
        return $this->private;
    }

    /**
     * Set private
     *
     * @param boolean $private
     *
     * @return $this
     */
    public function setPrivate($private)
    {
        Util::validateType($private, 'bool', '$private');
        $this->private = (bool)$private;
        return $this;
    }

    /**
     * Get privacy in original string form
     *
     * @return string
     */
    public function getPrivacyAsString()
    {
        return $this->isPrivate() ? 'private' : 'public';
    }

    /**
     * Set privacy from original string form
     *
     * @return string
     */
    public function setPrivacyFromString($privacy)
    {
        Util::validateType($privacy, 'string', '$privacy');

        if ($privacy != 'private' && $privacy != 'public') {
            throw new \InvalidArgumentException("\$privacy must be one of: private, public");
        }

        $this->setPrivate($privacy == 'private' ? true : false);
    }

    /**
     * Get likes
     *
     * @return int
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * Set likes
     *
     * @param int $likes
     *
     * @return $this
     */
    public function setLikes($likes)
    {
        Util::validateType($likes, 'int', '$likes');
        $this->likes = $likes;
        return $this;
    }

    /**
     * Get views
     *
     * @return int
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Set views
     *
     * @param int $views
     *
     * @return $this
     */
    public function setViews($views)
    {
        Util::validateType($views, 'int', '$views');
        $this->views = $views;
        return $this;
    }

    /**
     * Get comments
     *
     * @return int
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set comments
     *
     * @param int $comments
     *
     * @return $this
     */
    public function setComments($comments)
    {
        Util::validateType($comments, 'int', '$comments');
        $this->comments = $comments;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     *
     * @return $this
     */
    public function setTimestamp(\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp as string
     *
     * @return string
     */
    public function getTimestampAsString()
    {
        return $this->timestamp->format('r');
    }

    /**
     * Set timestamp from string
     *
     * @param string $timestamp
     *
     * @return $this
     */
    public function setTimestampFromString($timestamp)
    {
        Util::validateType($timestamp, 'string', '$timestamp');
        $this->setTimestamp(new \DateTime($timestamp));
        return $this;
    }
}
