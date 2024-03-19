<?php

namespace App\Filament\Resources\ProfileDataResource\Pages;

use App\Filament\Resources\ProfileDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProfileData extends ListRecords
{
    protected static string $resource = ProfileDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
