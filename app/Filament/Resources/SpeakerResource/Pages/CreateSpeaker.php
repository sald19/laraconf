<?php

declare(strict_types=1);

namespace App\Filament\Resources\SpeakerResource\Pages;

use App\Filament\Resources\SpeakerResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateSpeaker extends CreateRecord
{
    protected static string $resource = SpeakerResource::class;
}
