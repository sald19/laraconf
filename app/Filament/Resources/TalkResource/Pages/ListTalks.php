<?php

declare(strict_types=1);

namespace App\Filament\Resources\TalkResource\Pages;

use App\Enums\TalkStatus;
use App\Filament\Resources\TalkResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

final class ListTalks extends ListRecords
{
    protected static string $resource = TalkResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('all Talks'),
            'approved' => Tab::make('Approved')
                ->modifyQueryUsing(fn($query) => $query->where('status', TalkStatus::APPROVED)),
            'submitted' => Tab::make('Submitted')
                ->modifyQueryUsing(fn($query) => $query->where('status', TalkStatus::SUBMITTED)),
            'rejected' => Tab::make('Rejected')
                ->modifyQueryUsing(fn($query) => $query->where('status', TalkStatus::REJECTED)),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
