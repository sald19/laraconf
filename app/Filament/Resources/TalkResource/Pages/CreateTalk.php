<?php

declare(strict_types=1);

namespace App\Filament\Resources\TalkResource\Pages;

use App\Filament\Resources\TalkResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateTalk extends CreateRecord
{
    protected static string $resource = TalkResource::class;
}
