<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    public function form(Form $form): Form
    {
        return $form
        ->schema([

            Section::make('Create a Post')
                ->description('create posts over here.') //create description
                //->collapsible()       // hide unhide option
                //->aside()     //align items right side

                ->schema([ //create a seprate section

                    TextInput::make('title')->rules('min:3||max:5')->required(), //title is samen name in model and migrate
                    TextInput::make('slug')->unique(ignoreRecord:true)->required(),//already database la iruntha athu update aakum
                    

                    ColorPicker::make('color')->required(),
                    MarkdownEditor::make('content')->required()->columnSpanFull(), //columnSpan(3) enda 3/4 pangu varum
                ])->columnSpan(2)->columns(2),

                
                
                Group::make()->schema([
                    Section::make('Image')
                    ->collapsible()
                    ->schema([

                        FileUpload::make('thumbnail')->disk('public')->directory('thumbnails'),
                        
                        ])->columnSpan(1),


                    Section::make('Meta')->schema([

                        TagsInput::make('tags')->required(),
                        Checkbox::make('published'),
                    ])
    
                        ])->columns(1),

            


        ])->columns([//for mobile views
            'default'=>1,
            'md'=>1,
            'lg'=>2,
            'xl'=>3,
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\CheckboxColumn::make('published'),
                // Tables\Columns\ImageColumn::make('thumbnail'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                 Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
