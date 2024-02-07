<?php

declare(strict_types=1);

namespace App\Filament\Resources\SpeakerResource\Pages;

use App\Filament\Resources\SpeakerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

final class ListSpeakers extends ListRecords
{
    protected static string $resource = SpeakerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
