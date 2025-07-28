<?php

return [
    \App\Enums\AktifEnum::class => [
        \App\Enums\AktifEnum::AKTIF => 'Aktif',
        \App\Enums\AktifEnum::NONAKTIF => 'Non Aktif',
    ],
    \App\Enums\StatusPrecription::class => [
        \App\Enums\StatusPrecription::PENDING => 'Pending',
        \App\Enums\StatusPrecription::DILAYANI => 'Dilayani',
    ],
    \App\Enums\GenderEnum::class => [
        \App\Enums\GenderEnum::GENTLE => 'Laki-Laki',
        \App\Enums\GenderEnum::LADIES => 'Perempuan',
    ],
];
