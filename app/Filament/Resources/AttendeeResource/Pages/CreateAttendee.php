<?php

declare(strict_types=1);

namespace App\Filament\Resources\AttendeeResource\Pages;

use App\Filament\Resources\AttendeeResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateAttendee extends CreateRecord
{
    protected static string $resource = AttendeeResource::class;
}
