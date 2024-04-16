<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\RelationManagers\CommentsRelationManager;
use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Filament\Resources\PostResource\RelationManagers\AuthorsRelationManager;
use App\Models\Category;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use OpenSpout\Writer\XLSX\Manager\CommentsManager;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationGroup = "Blog";//nav bar items ku group create panna
    protected static ?int $navigationSort = 1;//set item order of the navbar items

    protected static ?string $navigationIcon = 'heroicon-o-folder'; //side bar icons

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Tabs::make('Create New Post')->tabs([
                    Tab::make('Tab 1')//make a tab of items(3 parts)
                    ->icon('heroicon-o-folder')
                    ->iconPosition(IconPosition::After)//set the icon position
                    ->schema([
                        TextInput::make('title')->numeric()->rules('min:3||max:5')->required(), //title is samen name in model and migrate
                        TextInput::make('slug')->unique(ignoreRecord:true)->required(),//already database la iruntha athu update aakum
                        Select::make('category_id')
                            ->label('category')
                            //->options(Category::all()->pluck('name', 'id')) //data come from categry table
                            ->relationship('category','name')//category connected in post model
                            ->searchable()
                            ->required(),

                        ColorPicker::make('color')->required(),
                    ]),
                    Tab::make('content')->schema([
                        MarkdownEditor::make('content')->required()->columnSpanFull(), //columnSpan(3) enda 3/4 pangu varum

                    ]),
                    Tab::make('Meta')->schema([//public file la add aakum
                        FileUpload::make('thumbnail')->disk('public')->directory('thumbnails'),
                            TagsInput::make('tags')->required(),
                            Checkbox::make('published'),

                    ])
                ])->columnSpanFull()->activeTab(3)->persistTabInQueryString(),//to send exact same page link
/* 
                Section::make('Create a Post')
                    ->description('create posts over here.') //create description
                    //->collapsible()       // hide unhide option
                    //->aside()     //align items right side

                    ->schema([ //create a seprate section

                        
                    ])->columnSpan(2)->columns(2),

                     */
                    
                  

                
                       /*  Section::make('Authors')->schema([
                            CheckboxList::make('authors')
                                ->label('Co Authors' )
                                ->relationship('authors','name')//define in post model
                                ->searchable()
                                
                        ]) */
        
                          

                


            ])->columns([//for mobile views
                'default'=>1,
                'md'=>1,
                'lg'=>2,
                'xl'=>3,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                ->sortable()//asending desendin order
                ->searchable()//search and find item
                ->toggleable(isToggledHiddenByDefault:true),

                ImageColumn::make('thumbnail') //make connection in post models
                ->toggleable(),//hide or unhide option

                ColorColumn::make('color')
                ->toggleable(),

                TextColumn::make('title')
                ->sortable()//asending desendin order
                ->searchable()//search and find item
                ->toggleable(),

                TextColumn::make('slug')
                ->sortable()
                ->searchable()
                ->toggleable()
                ,
                TextColumn::make('category.name') //get name from category table ,make connection in model
                ->toggleable(),

                TextColumn::make('tags')
                ->toggleable(),
                
                CheckboxColumn::make('published')
                ->toggleable(),
                TextColumn::make('created_at')
                ->label('Published on')
                ->date('Y D ')
                ->sortable()
                ->searchable()
                ->toggleable()
                ,

            ])


            ->filters([//table data va filter panni use panna
                Filter::make('Published Posts')->query(//filter published posts
                    function(Builder $query):Builder{
                        return $query->where('published',true);
                    }
                ),
                Filter::make('UnPublished Posts')->query(//filter unpublished posts
                    function(Builder $query):Builder{
                        return $query->where('published',false);
                    }
                ),

                TernaryFilter::make('published'),

                SelectFilter::make('category_id')
                ->label('Category')
                ->relationship('category','name')//defiene in post model
                // ->options(Category::all()->pluck('name'))
                ->multiple()//can multiple search options(vithu,nila)
                ->preload()//show search options
                ->searchable()
               
            ])
            ->actions([
                
                Tables\Actions\EditAction::make(),//edit button
                Tables\Actions\DeleteAction::make(),//delete button
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
            AuthorsRelationManager::class ,
            CommentsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
