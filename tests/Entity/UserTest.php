<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserTest extends TestCase
{

    public function testGettersAndSetters(): void
    {
        $user = new User();

        $user->setEmail("test@test.com");
        $user->setPassword("password");
        $user->setRoles(['ROLE_USER']);
        $user->setIsVerified(false);

        $this->assertEquals('test@test.com', $user->getEmail());
        $this->assertEquals('password', $user->getPassword());
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
        $this->assertEquals(false, $user->isVerified());
    }
}
