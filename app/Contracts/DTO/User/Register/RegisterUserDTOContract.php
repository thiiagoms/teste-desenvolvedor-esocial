<?php

declare(strict_types=1);

namespace App\Contracts\DTO\User\Register;

use App\Contracts\DTO\BaseDTOContract;
use App\DTO\User\Register\RegisterUserDTO;
use App\Http\Requests\User\Register\RegisterUserRequest;

interface RegisterUserDTOContract extends BaseDTOContract
{
    public static function fromRequest(RegisterUserRequest $request): RegisterUserDTO;

    public static function fromArray(array $payload): RegisterUserDTO;
}
