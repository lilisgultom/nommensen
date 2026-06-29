<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul Berita')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('contoh: B University Raih Akreditasi Unggul')
                    ->helperText('Slug URL akan dibuat otomatis dari judul ini.')
                    ->columnSpanFull(),

                RichEditor::make('content')
                    ->label('Isi Berita')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'bulletList',
                        'orderedList',
                        'link',
                        'h2',
                        'h3',
                    ])
                    ->required()
                    ->columnSpanFull(),

                FileUpload::make('image')
                    ->label('Foto Berita')
                    ->image()
                    ->directory('news')
                    ->visibility('public')
                    ->imagePreviewHeight('200')
                    ->maxSize(3072)
                    ->required()
                    ->helperText('Format: JPG, PNG. Maks 3MB.')
                    ->columnSpanFull(),

                Hidden::make('slug'),
                Hidden::make('users_id'),
            ]);
    }
}