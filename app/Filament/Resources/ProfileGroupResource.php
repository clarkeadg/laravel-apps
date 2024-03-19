<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfileGroupResource\Pages;
use App\Filament\Resources\ProfileGroupResource\RelationManagers;
use App\Models\ProfileGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProfileGroupResource extends Resource
{
    protected static ?string $model = ProfileGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard';

    protected static ?string $navigationLabel = 'Profile Extender';

    protected static ?string $navigationGroup = 'Members';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),                
                Forms\Components\Textarea::make('description'),
                Forms\Components\TextInput::make('group_order')->numeric()->default(0)              
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('profile_fields_count')
                    ->counts('profile_fields')
                    ->label('Fields'),
                Tables\Columns\TextColumn::make('group_order')
                    ->sortable(),
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
            ])
            ->defaultSort('group_order', 'asc');
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\ProfileFieldsRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfileGroups::route('/'),
            'create' => Pages\CreateProfileGroup::route('/create'),
            'edit' => Pages\EditProfileGroup::route('/{record}/edit'),
        ];
    }    
}
