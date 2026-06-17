<?php

namespace App\Filament\Resources\Histories;

use App\Filament\Resources\Histories\Pages;
use App\Models\History;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class HistoryResource extends Resource
{
    protected static ?string $model = History::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationLabel = 'Sejarah';

    protected static ?string $modelLabel = 'Sejarah';

    protected static ?string $pluralModelLabel = 'Sejarah';

    protected static string|\UnitEnum|null $navigationGroup = 'Profil Universitas';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\RichEditor::make('content')
                    ->label('Isi Sejarah')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'bulletList',
                        'orderedList',
                        'link',
                        'h3',
                    ])
                    ->required()
                    ->helperText('Ceritakan sejarah pendirian dan perkembangan universitas.')
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('image')
                    ->label('Foto Bersejarah')
                    ->image()
                    ->directory('histories')
                    ->visibility('public')
                    ->imagePreviewHeight('200')
                    ->maxSize(2048)
                    ->required()
                    ->helperText('Foto gedung lama / momen bersejarah. Format: JPG, PNG. Maks 2MB.')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Foto')
                    ->disk('public')
                    ->height(60),

                Tables\Columns\TextColumn::make('content')
                    ->label('Cuplikan Sejarah')
                    ->formatStateUsing(fn (?string $state): string => Str::limit(strip_tags($state ?? ''), 100))
                    ->wrap()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ditambahkan')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('updated_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHistories::route('/'),
            'create' => Pages\CreateHistory::route('/create'),
            'edit' => Pages\EditHistory::route('/{record}/edit'),
        ];
    }
}