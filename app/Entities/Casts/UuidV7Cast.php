<?php

namespace App\Entities\Casts;

use CodeIgniter\Entity\Cast\BaseCast;
use Ramsey\Uuid\Uuid;

class UuidV7Cast extends BaseCast
{
    public static function get($value, array $params = [])
    {
        if (empty($value)) {
            return null;
        }

        return Uuid::fromBytes($value)->toString();
    }

    public static function set($value, array $params = [])
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof \Ramsey\Uuid\UuidInterface) {
            return $value->getBytes();
        }

        if (Uuid::isValid($value)) {
            return Uuid::fromString($value)->getBytes();
        }

        throw new \InvalidArgumentException("Valor no vàlid per a UUID v7: " . $value);
    }
}
