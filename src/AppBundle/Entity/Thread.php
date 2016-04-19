<?php
/**
 * Created by PhpStorm.
 * User: rimas
 * Date: 4/20/16
 * Time: 12:36 AM
 */

namespace MyProject\MyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Thread as BaseThread;

/**
 * @ORM\Entity
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class Thread extends BaseThread
{
    /**
     * @var string $id
     *
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $id;
}
