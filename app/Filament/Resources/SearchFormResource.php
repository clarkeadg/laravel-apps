<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SearchFormResource\Pages;
use App\Filament\Resources\SearchFormResource\RelationManagers;
use App\Models\SearchForm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\ProfileGroup;

class SearchFormResource extends Resource
{
    protected static ?string $model = SearchForm::class;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';

    protected static ?string $navigationLabel = 'Search Forms';

    protected static ?string $navigationGroup = 'Members';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        $groups = ProfileGroup::orderBy("group_order", "asc")->get();
        $fieldOptions = [];
        foreach($groups as $group) {
            $fieldOptions[$group->name] = [];
            $fields = $group->profile_fields()->get();
            foreach($fields as $field) {
                $fieldOptions[$group->name][$field->id] = $field->name;
            }
        }
        
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Repeater::make('options')->default(null)                    
                    ->schema([
                        Forms\Components\Select::make('field_id')
                            ->label("Field")
                            ->required()
                            ->options($fieldOptions),
                        Forms\Components\TextInput::make('label'),
                        Forms\Components\TextInput::make('description'),
                        Forms\Components\Select::make('search_mode')
                            ->options([
                                "is" => "is",
                                "is_one_of" => "is one of"
                            ]),
                    ])->columns(4)
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSearchForms::route('/'),
            'create' => Pages\CreateSearchForm::route('/create'),
            'edit' => Pages\EditSearchForm::route('/{record}/edit'),
        ];
    }    
}
