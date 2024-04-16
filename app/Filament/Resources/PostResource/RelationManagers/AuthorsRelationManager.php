<?php

namespace App\Filament\Resources\PostResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AuthorsRelationManager extends RelationManager
{
    protected static string $relationship = 'authors';

    public function form(Form $form): Form
    {
        return $form
            ->schema([

               TextInput::make('name')->required(),//red dot says require value
                TextInput::make('email')->email(),//say @ sign
                //TextInput::make('password')->password()->readOnlyOn('edit')//hide letters, edit la password box la cant make changes
                TextInput::make('password')->password()->visibleOn('create'),//hide letters, password box only visiable on create page
                TextInput::make('order')->numeric()->visibleOn('create')
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable(),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('order')->sortable(),
                /* TextColumn::make('id'),
                TextColumn::make('name'),
                TextColumn::make('email'), */
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()   
                ->form(fn (AttachAction $action): array => [//copy from fialment=>Attaching with pivot attributes
                    $action->getRecordSelect(),
                    Forms\Components\TextInput::make('order')->numeric()->required(),
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
                //Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
