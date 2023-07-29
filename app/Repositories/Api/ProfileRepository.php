<?php
namespace App\Repositories\Api;

use App\Factory\FactoryRepository;
use App\Models\Profile;

class ProfileRepository extends FactoryRepository
{
    public function __construct(Profile $profile)
    {
        parent::__construct($profile);
    }
}
