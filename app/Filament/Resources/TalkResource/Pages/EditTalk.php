<?php

declare(strict_types=1);

namespace App\Filament\Resources\TalkResource\Pages;

use App\Filament\Resources\TalkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditTalk extends EditRecord
{
    protected static string $resource = TalkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
