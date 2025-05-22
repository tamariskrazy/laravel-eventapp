<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DuyurularResource\Pages;
use App\Filament\Resources\DuyurularResource\RelationManagers;
use App\Models\Duyurular;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DuyurularResource extends Resource
{
    protected static ?string $model = Duyurular::class;

    protected static ?string $navigationIcon = 'heroicon-o-bell';

    protected static ?string $navigationLabel = 'Duyurular';
    protected static ?int $navigationSort = 3;

    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListDuyurulars::route('/'),
            'create' => Pages\CreateDuyurular::route('/create'),
            'edit' => Pages\EditDuyurular::route('/{record}/edit'),
        ];
    }
}
