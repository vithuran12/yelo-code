<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\RelationManagers\PostsRelationManager;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = "User";//nav bar items ku group create panna

    public static function form(Form $form): Form//create form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),//red dot says require value
                TextInput::make('email')->email(),//say @ sign
                //TextInput::make('password')->password()->readOnlyOn('edit')//hide letters, edit la password box la cant make changes
                TextInput::make('password')->password()->visibleOn('create')//hide letters, password box only visiable on create page

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table//create atable view
            ->columns([
                // TextColumn::make('id'),
                // TextColumn::make('name'),
                // TextColumn::make('email'),
                
                //TextColumn::make('updated_at'),
                // TextColumn::make('created_at'),

                Tables\Columns\TextColumn::make('name')
                ->searchable(),
                
                Tables\Columns\TextColumn::make('email')
                ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault:true),

                Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault:true),
                
                Tables\Columns\TextColumn::make('role')
                ->badge()
                ->color(function (string $state): string {
                   // return 'info';
                  /*  if ($state == 'ADMIN') return 'danger';
                   return 'gray'; */

                   return match($state){
                    'ADMIN'=>'danger',  //red
                    'EDITOR'=>'info',    //red
                    'USER'=>'success'//red

                   };
                })
                ->searchable()
                ->sortable()

                

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
           //  PostsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
