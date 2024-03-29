<?php

declare(strict_types=1);

namespace App\Models;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Speaker extends Model
{
    use HasFactory;

    public const QUALIFICATIONS = [
        'business-leader' => 'Business Leader',
        'charisma' => 'Charismatic Speaker',
        'first-time' => 'First Time Speaker',
        'hometown hero' => 'Hometown Hero',
        'humanitarian' => 'Works in Humanitarian Field',
        'Laracasts-contributor' => 'Laracasts Contributor',
        'twitter-influencer' => 'Large Twitter Following',
        'youtube-influencer' => 'Large YouTube Following',
        'open-source' => 'Open Source Creator / Maintainer',
        'unique-perspective' => 'Unique Perspective',
    ];

    protected $fillable = [
        'avatar',
        'bio',
        'email',
        'name',
        'qualifications',
        'twitter_handle',
    ];

    protected $casts = [
        'id' => 'integer',
        'qualifications' => 'array',
    ];

    public static function getForm()
    {
        return [
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            FileUpload::make('avatar')
                ->avatar()
                ->directory('avatars')
                ->imageEditor()
                ->maxSize(1024 * 1024 * 10),
            TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),
            RichEditor::make('bio')
                ->maxLength(65535)
                ->columnSpanFull(),
            TextInput::make('twitter_handle')
                ->maxLength(255),
            CheckboxList::make('qualifications')
                ->columnSpanFull()
                ->bulkToggleable()
                ->searchable()
                ->options(self::QUALIFICATIONS)
                ->descriptions([
                    'business-leader' => 'Here is a nice long description',
                    'charisma' => 'this is event more information about you should pick this one',
                ])
                ->columns(3),

        ];
    }

    public function talks(): HasMany
    {
        return $this->hasMany(Talk::class);
    }

    public function conferences(): BelongsToMany
    {
        return $this->belongsToMany(Conference::class);
    }
}
