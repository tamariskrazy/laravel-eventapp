<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KullanıcıYönetimiResource\Pages;
use App\Models\KullanıcıYönetimi;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;

class KullanıcıYönetimiResource extends Resource
{
    protected static ?string $model = KullanıcıYönetimi::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Kullanıcı';
    protected static ?int $navigationSort = 1;

   

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Form alanları burada olacaksa ekleyebilirsin
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('isim')->label('İsim')->searchable(),
                Tables\Columns\TextColumn::make('soyisim')->label('Soyisim')->searchable(),
                Tables\Columns\TextColumn::make('email')->label('E-posta')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->label('Kayıt Tarihi')->dateTime('d.m.Y H:i')->sortable(),
                Tables\Columns\TextColumn::make('is_approved')
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
                    ->action(function ($record) {
                        $record->update(['is_approved' => true]);
                    })
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-check'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListKullanıcıYönetimis::route('/'),
            'create' => Pages\CreateKullanıcıYönetimi::route('/create'),
            'edit' => Pages\EditKullanıcıYönetimi::route('/{record}/edit'),
        ];
    }
}
