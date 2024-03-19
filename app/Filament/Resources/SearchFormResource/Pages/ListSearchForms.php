<?php

namespace App\Filament\Resources\SearchFormResource\Pages;

use App\Filament\Resources\SearchFormResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSearchForms extends ListRecords
{
    protected static string $resource = SearchFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
