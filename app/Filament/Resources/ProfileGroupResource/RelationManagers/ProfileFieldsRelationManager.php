<?php

namespace App\Filament\Resources\ProfileGroupResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProfileFieldsRelationManager extends RelationManager
{
    protected static string $relationship = 'profile_fields';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('placeholder')
                    ->maxLength(255),
                Forms\Components\Textarea::make('description'),
                Forms\Components\Select::make('type')
                    ->options([                        
                        'textbox' => 'Text',
                        'textarea' => 'Text Area',
                        'number' => 'Number',
                        'telephone' => 'Phone Number',
                        'url' => 'URL',
                        'checkbox_acceptance' => 'Checkbox Acceptance',
                        'datebox' => 'Date Selector',
                        'selectbox' => 'Select Box',
                    ])
                    ->required()
                    ->live(),
                Forms\Components\TextInput::make('field_order')->numeric()->default(0),
                Forms\Components\Repeater::make('options')->default(null)                    
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('value')
                            ->maxLength(255),
                        Forms\Components\Checkbox::make('is_default'),
                    ])
                    ->hidden(fn (Get $get) => $get('type') !== 'selectbox')
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('field_order')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->defaultSort('field_order', 'asc');
    }
}
