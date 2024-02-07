<?php

declare(strict_types=1);

namespace App\Filament\Resources\SpeakerResource\Pages;

use App\Filament\Resources\SpeakerResource;
use App\Models\Speaker;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

final class ViewSpeaker extends ViewRecord
{
    protected static string $resource = SpeakerResource::class;

    protected function getHeaderActions(): array
    {

        return [
            Actions\EditAction::make()
                ->slideOver()
                ->form(Speaker::getForm()),
        ];
    }
}
