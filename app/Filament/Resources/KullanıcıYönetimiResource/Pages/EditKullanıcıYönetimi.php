<?php

namespace App\Filament\Resources\KullanıcıYönetimiResource\Pages;

use App\Filament\Resources\KullanıcıYönetimiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKullanıcıYönetimi extends EditRecord
{
    protected static string $resource = KullanıcıYönetimiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
