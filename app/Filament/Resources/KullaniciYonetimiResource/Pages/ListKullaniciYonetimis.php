<?php

namespace App\Filament\Resources\KullaniciYonetimiResource\Pages;

use App\Filament\Resources\KullaniciYonetimiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKullaniciYonetimis extends ListRecords
{
    protected static string $resource = KullaniciYonetimiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
