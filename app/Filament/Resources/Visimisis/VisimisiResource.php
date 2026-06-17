<?php

namespace App\Filament\Resources\Visimisis;

use App\Filament\Resources\Visimisis\Pages;
use App\Models\Visimisi;
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

class VisimisiResource extends Resource
{
    protected static ?string $model = Visimisi::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-eye';

    protected static ?string $navigationLabel = 'Visi & Misi';

    protected static ?string $modelLabel = 'Visi & Misi';

    protected static ?string $pluralModelLabel = 'Visi & Misi';

    protected static string|\UnitEnum|null $navigationGroup = 'Profil Universitas';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\RichEditor::make('visi')
                    ->label('Visi')
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
                    ->columnSpanFull(),

                Forms\Components\RichEditor::make('misi')
                    ->label('Misi')
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
                    ->helperText('Gunakan numbered list untuk menuliskan poin-poin misi.')
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('image')
                    ->label('Foto (Multiple)')
                    ->image()
                    ->multiple()
                    ->reorderable()
                    ->maxFiles(5)
                    ->directory('visimisis')
                    ->visibility('public')
                    ->imagePreviewHeight('120')
                    ->maxSize(2048)
                    ->required()
                    ->helperText('Bisa upload beberapa foto. Maks 5 foto, masing-masing 2MB.')
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
                    ->height(50)
                    ->stacked()
                    ->limit(3)
                    ->limitedRemainingText(),

                Tables\Columns\TextColumn::make('visi')
                    ->label('Visi')
                    ->formatStateUsing(fn (?string $state): string => Str::limit(strip_tags($state ?? ''), 60))
                    ->wrap()
                    ->searchable(),

                Tables\Columns\TextColumn::make('misi')
                    ->label('Misi')
                    ->formatStateUsing(fn (?string $state): string => Str::limit(strip_tags($state ?? ''), 60))
                    ->wrap()
                    ->toggleable(),

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
            'index' => Pages\ListVisimisis::route('/'),
            'create' => Pages\CreateVisimisi::route('/create'),
            'edit' => Pages\EditVisimisi::route('/{record}/edit'),
        ];
    }
}