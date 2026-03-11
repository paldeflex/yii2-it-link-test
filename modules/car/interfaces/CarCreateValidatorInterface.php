<?php

namespace app\modules\car\interfaces;

interface CarCreateValidatorInterface
{
    public function validate(array $data): array;
}