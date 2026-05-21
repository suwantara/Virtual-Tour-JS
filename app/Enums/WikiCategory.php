<?php

namespace App\Enums;

enum WikiCategory: string
{
    case Sejarah = 'sejarah';
    case Pelinggih = 'pelinggih';
    case Ritual = 'ritual';
    case Tokoh = 'tokoh';
    case Glosarium = 'glosarium';
    case Info = 'info';

    public function label(): string
    {
        return match ($this) {
            self::Sejarah => 'Sejarah & Latar Belakang',
            self::Pelinggih => 'Pelinggih',
            self::Ritual => 'Ritual & Upacara',
            self::Tokoh => 'Tokoh',
            self::Glosarium => 'Glosarium',
            self::Info => 'Informasi Umum',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Sejarah => 'heroicon-o-book-open',
            self::Pelinggih => 'heroicon-o-building-library',
            self::Ritual => 'heroicon-o-sparkles',
            self::Tokoh => 'heroicon-o-user',
            self::Glosarium => 'heroicon-o-language',
            self::Info => 'heroicon-o-information-circle',
        };
    }
}
