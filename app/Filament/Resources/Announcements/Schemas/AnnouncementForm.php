<?php

namespace App\Filament\Resources\Announcements\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AnnouncementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul Pengumuman')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('contoh: Jadwal UAS Semester Ganjil 2025/2026')
                    ->helperText('Slug URL akan dibuat otomatis dari judul ini.')
                    ->columnSpanFull(),

                RichEditor::make('content')
                    ->label('Isi Pengumuman')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'bulletList',
                        'orderedList',
                        'link',
                    ])
                    ->required()
                    ->columnSpanFull(),

                Hidden::make('slug'),
                Hidden::make('users_id'),
            ]);
    }
}