<?php

namespace App\Filament\Resources\ProfileGroupResource\Pages;

use App\Filament\Resources\ProfileGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProfileGroups extends ListRecords
{
    protected static string $resource = ProfileGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
