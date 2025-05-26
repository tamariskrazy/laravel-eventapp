<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KullaniciYonetimiResource\Pages;
use App\Models\KullaniciYonetimi;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class KullaniciYonetimiResource extends Resource
{
    protected static ?string $model = KullaniciYonetimi::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Kullanıcı';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Buraya form alanlarını ekleyebilirsin
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('isim')->label('İsim')->searchable(),
                TextColumn::make('soyisim')->label('Soyisim')->searchable(),
                TextColumn::make('email')->label('E-posta')->searchable(),
                TextColumn::make('created_at')->label('Kayıt Tarihi')->dateTime('d.m.Y H:i')->sortable(),
                TextColumn::make('is_approved')
                    ->label('Durum')
                    ->formatStateUsing(fn ($state) => $state ? 'Onaylı' : 'Onaysız')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
            ])
            ->actions([
                EditAction::make(),
                Action::make('onayla')
                    ->label('Onayla')
                    ->visible(fn ($record) => !$record->is_approved)
                    ->action(fn ($record) => $record->update(['is_approved' => true]))
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-check'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKullaniciYonetimis::route('/'),
            'create' => Pages\CreateKullaniciYonetimi::route('/create'),
            'edit' => Pages\EditKullaniciYonetimi::route('/{record}/edit'),
        ];
    }
}
