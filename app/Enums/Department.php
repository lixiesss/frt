<?php

namespace App\Enums;

enum Department: string
{
    case BPH = 'BPH';
    case ID = 'ID';
    case CNB = 'CnB';
    case HRD = 'HRD';
    case XR = 'XR';
    case IS = 'IS';
    case AC = 'AC';

    public function label(): string
    {
        return match ($this) {
            self::BPH => 'Badan Pengurus Harian',
            self::ID => 'Internal Development',
            self::CNB => 'Creative n Branding',
            self::HRD => 'Human Resource Development',
            self::XR => 'External Relationship',
            self::IS => 'Information System',
            self::AC => 'Academic',
        };
    }

    public function slug(): string
    {
        return $this->value;
    }
}
