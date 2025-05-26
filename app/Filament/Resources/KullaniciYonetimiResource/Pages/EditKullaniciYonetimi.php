<?php

namespace App\Filament\Resources\KullaniciYonetimiResource\Pages;

use App\Filament\Resources\KullaniciYonetimiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKullaniciYonetimi extends EditRecord
{
    protected static string $resource = KullaniciYonetimiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
