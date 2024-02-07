<?php

declare(strict_types=1);

namespace App\Filament\Speakers\Resources\AttendeeResource\Pages;

use App\Filament\Speakers\Resources\AttendeeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

final class ListAttendees extends ListRecords
{
    protected static string $resource = AttendeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
