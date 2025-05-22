<?php

namespace App\Filament\Resources\KullanıcıYönetimiResource\Pages;

use App\Filament\Resources\KullanıcıYönetimiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKullanıcıYönetimis extends ListRecords
{
    protected static string $resource = KullanıcıYönetimiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
