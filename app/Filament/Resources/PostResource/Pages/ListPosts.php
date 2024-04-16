<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    //for create tabs in post table
    public function getTabs(): array//import tab and other items 
    {
        return[
            'All'=>Tab::make(),//'All' is tab name
            'Published'=>Tab::make()->modifyQueryUsing(function(Builder $query){//Builder for suggestion 
                $query->where('published',true);//deffined in the post table
            }),

            'Un Published'=>Tab::make()->modifyQueryUsing(function(Builder $query){//Builder for suggestion 
                $query->where('published',false);//deffined in the post table
            }),
        ];
    }
}
