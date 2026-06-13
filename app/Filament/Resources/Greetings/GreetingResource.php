<?php

namespace App\Filament\Resources\Greetings;

use App\Filament\Resources\Greetings\Pages\CreateGreeting;
use App\Filament\Resources\Greetings\Pages\EditGreeting;
use App\Filament\Resources\Greetings\Pages\ListGreetings;
use App\Filament\Resources\Greetings\Pages\ViewGreeting;
use App\Filament\Resources\Greetings\Schemas\GreetingInfolist;
use App\Models\Greeting;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class GreetingResource extends Resource
{
    protected static ?string $model = Greeting::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';
    protected static ?string $navigationLabel = 'Sambutan';
    protected static ?string $modelLabel = 'Sambutan';
    protected static ?string $pluralModelLabel = 'Sambutan';
    protected static string|\UnitEnum|null $navigationGroup = 'Manajemen Konten';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\RichEditor::make('content')
                    ->label('Isi Sambutan')
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'bulletList',
                        'orderedList', 'link', 'h2', 'h3',
                        'blockquote', 'redo', 'undo',
                    ])
                    ->required()
                    ->helperText('Tulis isi sambutan pimpinan universitas.')
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('image')
                    ->label('Foto Pimpinan')
                    ->image()
                    ->directory('greetings')
                    ->visibility('public')
                    ->imagePreviewHeight('200')
                    ->maxSize(2048)
                    ->required()
                    ->helperText('Upload foto pimpinan. Format: JPG, PNG. Maks 2MB.')
                    ->columnSpanFull(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return GreetingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Foto')
                    ->disk('public')
                    ->height(60)
                    ->circular(),
                Tables\Columns\TextColumn::make('content')
                    ->label('Cuplikan Sambutan')
                    ->formatStateUsing(fn (?string $state): string => Str::limit(strip_tags($state ?? ''), 80))
                    ->wrap(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ditambahkan')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGreetings::route('/'),
            'create' => CreateGreeting::route('/create'),
            'view' => ViewGreeting::route('/{record}'),
            'edit' => EditGreeting::route('/{record}/edit'),
        ];
    }
}