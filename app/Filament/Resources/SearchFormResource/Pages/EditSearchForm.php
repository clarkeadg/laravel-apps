<?php

namespace App\Filament\Resources\SearchFormResource\Pages;

use App\Filament\Resources\SearchFormResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSearchForm extends EditRecord
{
    protected static string $resource = SearchFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
