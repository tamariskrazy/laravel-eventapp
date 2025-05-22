<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EtkinlikYönetimiResource\Pages;
use App\Filament\Resources\EtkinlikYönetimiResource\RelationManagers;
use App\Models\EtkinlikYönetimi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Tables\Columns\BadgeColumn;


class EtkinlikYönetimiResource extends Resource
{
    protected static ?string $model = EtkinlikYönetimi::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Etkinlik';
    protected static ?int $navigationSort = 2;

    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('etkinlik_adi')
                    ->label('Etkinlik Adı')
                    ->required()
                    ->maxLength(255),

                DatePicker::make('tarih')
                    ->label('Tarih')
                    ->required(),

                TextInput::make('description')
                    ->label('Kısa Açıklama')
                    ->maxLength(255),

                TextInput::make('yeri')
                    ->label('Yer')
                    ->required()
                    ->maxLength(255),

                Select::make('turu')
                    ->label('Tür')
                    ->required()
                    ->options([
                        'tiyatro' => 'Tiyatro',
                        'konser' => 'Konser',
                        'müzikal' => 'Müzikal',
                        'sinema' => 'Sinema',
                    ]),

                TagsInput::make('ilgi_alani')
                    ->label('İlgi Alanları')
                    ->placeholder('örnek: dram, aksiyon, komedi')
                    ->suggestions([
                        'dram',
                        'aksiyon',
                        'komedi',
                        'romantik',
                        'bilim kurgu',
                        'şiddet',
                    ])
                    ->separator(','),
            ]);
    
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               TextColumn::make('etkinlik_adi')->label('Etkinlik Adı')->searchable(),
                TextColumn::make('tarih')->label('Tarih')->date('d.m.Y'),
                TextColumn::make('yeri')->label('Yer'),
                TextColumn::make('turu')->label('Tür'),
                BadgeColumn::make('ilgi_alani')
                    ->label('İlgi Alanları')
                    ->colors([
                        'primary',
                        'success',
                        'warning',
                        'danger',
                    ]),
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
            'index' => Pages\ListEtkinlikYönetimis::route('/'),
            'create' => Pages\CreateEtkinlikYönetimi::route('/create'),
            'edit' => Pages\EditEtkinlikYönetimi::route('/{record}/edit'),
        ];
    }
}
