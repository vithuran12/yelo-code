<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Filament\Resources\CategoryResource\RelationManagers\PostsRelationManager;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static bool $shouldSkipAuthorization = true;//to skip autorization
    protected static ?string $navigationIcon = 'heroicon-o-folder';//change icon
    protected static ?string $modelLabel = 'Post Categories';//side bar name
    protected static ?string $navigationGroup = "Blog";//nav bar items ku group create panna
    protected static ?int $navigationSort = 2;//set item order of the navbar items
    protected static ?string $navigationParentItem = 'Posts';//Posts(label name) nav item ithukku parent aaka irukum

    
    public static function form(Form $form): Form//category la irukira create form la columns add panna
    {
        return $form
        ->schema([
            TextInput::make('name')->required()
            // ->live(debounce: 5000) //afterstate la eluthina mater 5 secound la nadakkum
                ->live(onBlur:true)//type panave update nadakkum, onblure true enda input box ku out side la click panna nadakkum
                ->afterStateUpdated(function(string $operation, string $state, Forms\Set $set, Forms\Get $get){
                    // dump("hi");
                    // dump($operatio,,n);//current operation on which page (edit,view,create)
                    // dump($state);//current value of name box
                    dump($get('slug'));//slug la irukira value ahh dump panum
                    //set enda entha input box ku antha value ahh set panna poramo athan
                    // $set('slug','my slug');//name update panna slug la my slug endu text change aakum
              /*       if($operation === 'edit'){//edit page la intha changes nadakkathu only in createpage
                        return;
                    }
                    $set('slug',Str::slug($state));//name field la update panna value slug la update aakum
 */
                }),
            TextInput::make('slug')->required(),

        ]);

           /*  ->schema([
                TextInput::make('title')->required()->minlength(1)->maxLength(150)
                // ->live()
                ->afterStateUpdated(function(){
                    dump("hi");
                })
                ,
    
                TextInput::make('slug')->required()->minLength(1)->unique(ignoreRecord:true)->maxLength(120),
    
                TextInput::make('text_color')->nullable(),
                TextInput::make('bg_color')->required(),
    
                ]);
                 */
        }
        
        public static function table(Table $table): Table//db la irukira datashow panna table 
        {
            return $table
            ->columns([
                
                TextColumn::make('name'),
                TextColumn::make('slug'),
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
               // Tables\Actions\DeleteAction::make(),
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
            PostsRelationManager::class//link postrelation page from post models
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
