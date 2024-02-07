<?php

declare(strict_types=1);

namespace App\Filament\Resources\ConferenceResource\Pages;

use App\Filament\Resources\ConferenceResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateConference extends CreateRecord
{
    protected static string $resource = ConferenceResource::class;
}
