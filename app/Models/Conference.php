<?php

namespace App\Models;

use App\Enums\Region;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Conference extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
        'region',
        'venue_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'region' => Region::class,
        'venue_id' => 'integer',
    ];

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    public function speakers(): BelongsToMany
    {
        return $this->belongsToMany(Speaker::class);
    }

    public function talks(): BelongsToMany
    {
        return $this->belongsToMany(Talk::class);
    }

    public static function getForm(): array
    {
        return [
            TextInput::make('name')
                ->label('Conference')
                ->required()
                ->maxLength(255),
            MarkdownEditor::make('description')
                ->required()
                ->maxLength(255),
            DateTimePicker::make('start_date')
                ->native(false)
                ->required(),
            DateTimePicker::make('end_date')
                ->native(false)
                ->required(),
            Select::make('status')
                ->options([
                    'draft' => 'Draft',
                    'published' => 'Published',
                    'archived' => 'Archived',
                ])
                ->required(),
            Select::make('region')
                ->live()
                ->enum(Region::class)
                ->options(Region::class),
            Select::make('venue_id')
                ->searchable()
                ->preload()
                ->createOptionForm(Venue::getForm())
                ->editOptionForm(Venue::getForm())
                ->relationship('venue', 'name', modifyQueryUsing: function (Builder $query, Get $get) {
                    return $query->where('region', $get('region'));
                }),
            CheckboxList::make('speakers')
                ->relationship('speakers', 'name')
                ->bulkToggleable()
                ->searchable()
                ->options(Speaker::pluck('name', 'id'))
                ->descriptions([
                    'business-leader' => 'Here is a nice long description',
                    'charisma' => 'this is event more information about you should pick this one',
                ])
                ->required(),
        ];
    }
}
