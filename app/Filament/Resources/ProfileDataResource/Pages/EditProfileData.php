<?php

namespace App\Filament\Resources\ProfileDataResource\Pages;

use App\Filament\Resources\ProfileDataResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProfileData extends EditRecord
{
    protected static string $resource = ProfileDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
