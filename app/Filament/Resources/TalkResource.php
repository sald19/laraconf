<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\TalkLength;
use App\Enums\TalkStatus;
use App\Filament\Resources\TalkResource\Pages;
use App\Models\Talk;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

final class TalkResource extends Resource
{
    protected static ?string $model = Talk::class;

    //    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Second Group';

    public static function form(Form $form): Form
    {
        return $form->schema(Talk::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->persistFiltersInSession()
            ->filtersTriggerAction(fn($action) => $action->button()->label('Filters'))
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->description(fn(Talk $record) => Str::limit($record->abstract, 40)),
                Tables\Columns\ImageColumn::make('speaker.avatar')
                    ->label('Speaker Avatar')
                    ->circular()
                    ->defaultImageUrl(fn(Talk $record) => 'https://ui-avatars.com/api/?background=0D8ABC&color=fff&name=' . urldecode($record->speaker->name)),
                Tables\Columns\TextColumn::make('speaker.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('new_talk'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable()
                    ->color(fn(TalkStatus $state) => $state->getColor()),
                Tables\Columns\IconColumn::make('length')
                    ->icon(function ($state) {
                        return match ($state) {
                            TalkLength::NORMAL => 'heroicon-o-megaphone',
                            TalkLength::LIGHTNING => 'heroicon-o-bolt',
                            TalkLength::KEYNOTE => 'heroicon-o-key',
                        };
                    }),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('new_talk'),
                Tables\Filters\SelectFilter::make('speaker')
                    ->relationship('speaker', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                Tables\Filters\Filter::make('has_avatar')
                    ->label('Show Only Speakers With Avatars')
                    ->toggle()
                    ->query(fn($query) => $query->whereHas('speaker', fn($query) => $query->whereNotNull('avatar'))),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->slideOver(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('approve')
                        ->visible(fn($record) => TalkStatus::SUBMITTED === $record->status)
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function (Talk $record): void {
                            $record->approve();
                        })->after(function (): void {
                            Notification::make()->success()->title('This Talk was approved')
                                ->duration(1000)
                                ->body('The Speaker has been notified and the talk has been added to the conference schedule.')
                                ->Send();
                        }),
                    Tables\Actions\Action::make('rejected')
                        ->icon('heroicon-o-no-symbol')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->visible(fn($record) => TalkStatus::SUBMITTED === $record->status)
                        ->action(function (Talk $record): void {
                            $record->reject();
                        })->after(function (): void {
                            Notification::make()->danger()->title('This Talk was rejected')
                                ->duration(1000)
                                ->body('The Speaker has been notified.')
                                ->Send();
                        }),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('approve')
                        ->action(function (Collection $records): void {
                            $records->each->approve();
                        }),
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('export')
                    ->tooltip('This willa export all records visble in the table. Adjust filters to export a subset of records.')
                    ->action(function ($livewire): void {
                        logger('furulla furullera');
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTalks::route('/'),
            'create' => Pages\CreateTalk::route('/create'),
            'edit' => Pages\EditTalk::route('/{record}/edit'),
        ];
    }
}
