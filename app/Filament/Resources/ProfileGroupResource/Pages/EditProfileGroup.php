<?php

namespace App\Filament\Resources\ProfileGroupResource\Pages;

use App\Filament\Resources\ProfileGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProfileGroup extends EditRecord
{
    protected static string $resource = ProfileGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
