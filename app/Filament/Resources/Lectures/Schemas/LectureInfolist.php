<?php

namespace App\Filament\Resources\Lectures\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class LectureInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nama')->label('Nama Lengkap'),
                TextEntry::make('nidn')->label('NIDN'),
                TextEntry::make('jabatan')->label('Jabatan Fungsional'),
                TextEntry::make('email')->label('Email'),
                TextEntry::make('topik')->label('Bidang Keahlian'),
                TextEntry::make('pendidikan')->label('Riwayat Pendidikan'),
                ImageEntry::make('image')
                    ->label('Foto')
                    ->disk('public')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->label('Ditambahkan')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}