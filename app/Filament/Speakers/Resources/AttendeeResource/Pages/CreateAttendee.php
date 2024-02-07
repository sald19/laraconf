<?php

declare(strict_types=1);

namespace App\Filament\Speakers\Resources\AttendeeResource\Pages;

use App\Filament\Speakers\Resources\AttendeeResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateAttendee extends CreateRecord
{
    protected static string $resource = AttendeeResource::class;
}
