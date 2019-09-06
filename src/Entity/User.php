<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as FOSUser;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_8D93D64992FC23A8", columns={"username_canonical"}), @ORM\UniqueConstraint(name="UNIQ_8D93D649C05FB297", columns={"confirmation_token"}), @ORM\UniqueConstraint(name="UNIQ_8D93D649A0D96FBF", columns={"email_canonical"})})
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User extends FOSUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=180, nullable=false)
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(name="username_canonical", type="string", length=180, nullable=false)
     */
    protected $usernameCanonical;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=180, nullable=false)
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(name="email_canonical", type="string", length=180, nullable=false)
     */
    protected $emailCanonical;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    protected $enabled;

    /**
     * @var string|null
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    protected $salt = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    protected $password;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true, options={"default"="NULL"})
     */
    protected $lastLogin = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="confirmation_token", type="string", length=180, nullable=true, options={"default"="NULL"})
     */
    protected $confirmationToken = 'NULL';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="password_requested_at", type="datetime", nullable=true, options={"default"="NULL"})
     */
    protected $passwordRequestedAt = 'NULL';

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array", length=0, nullable=false)
     */
    protected $roles;

}
