<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiswaResource\Pages;
use App\Filament\Resources\SiswaResource\RelationManagers;
use App\Models\Siswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Textarea; 

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               
             Forms\Components\TextInput::make('nis')
                ->required()
                ->unique(ignoreRecord: true) // Pastikan NIS unik, abaikan record saat ini saat edit
                ->maxLength(255),
            Forms\Components\TextInput::make('nama')
                    ->required() // Kolom nama wajib diisi
                    ->maxLength(255),
                Forms\Components\TextInput::make('kelas')
                    ->required() // Kolom kelas wajib diisi
                    ->maxLength(255),
                Forms\Components\TextInput::make('jurusan')
                    ->required() // Kolom jurusan wajib diisi
                    ->maxLength(255),
                    
                     Textarea::make('alamat')
                    ->rows(3)
                    ->maxLength(65535) // Menggunakan 65535 (maksimum untuk TEXT) atau sesuai kebutuhan Anda
                    ->nullable(),
                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nis')
                ->searchable()
                ->sortable(), // NIS bisa dicari dan diurutkan
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kelas')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('jurusan')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('alamat')
                ->searchable()
                ->wrap(), // Agar teks panjang bisa wrapping di tabel
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiswas::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            'edit' => Pages\EditSiswa::route('/{record}/edit'),
        ];
    }
}
