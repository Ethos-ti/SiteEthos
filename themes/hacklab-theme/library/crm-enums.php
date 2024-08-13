<?php

namespace ethos\crm;

enum ContactStatus: int {
    case Active = 0;
    case Inactive = 1;

    public static function isActive (int $statecode): bool {
        $value = self::tryFrom($statecode);
        return $value === self::Active;
    }
}

enum CompanySize: int {
    case Micro = 969830000;
    case Pequena = 969830001;
    case Media = 969830002;
    case MediaGrande = 969830003;
    case Grande1 = 969830004;
    case Grande2 = 969830005;
    case Grande3 = 969830006;

    public static function fromSlug (string $slug): int {
        return match ($slug) {
            'micro' => self::Micro->value,
            'small' => self::Pequena->value,
            'medium' => self::Media->value,
            'large' => self::Grande1->value,
        };
    }

    public static function toSlug (int|null $pl_porte): string {
        if (empty($pl_porte)) {
            return 'micro';
        }

        $size = self::from($pl_porte);
        return match ($size) {
            self::Micro => 'micro',
            self::Pequena => 'small',
            self::Media, self::MediaGrande => 'medium',
            self::Grande1, self::Grande2, self::Grande3 => 'large',
        };
    }
}
