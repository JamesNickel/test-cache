<?php

namespace App\Models\Entities;

use Eghamat24\DatabaseRepository\Models\Entity\Entity;

class User extends Entity
{
    public int $id;

	public string $name;

	public string $email;

	public null|string $emailVerifiedAt = null;

	public string $password;

	public null|string $twoFactorSecret = null;

	public null|string $twoFactorRecoveryCodes = null;

	public null|string $twoFactorConfirmedAt = null;

	public null|string $rememberToken = null;

	public null|string $createdAt = null;

	public null|string $updatedAt = null;
}
