<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TestWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('New User',User::count())//title of card,value of card
                 ->description('32k increase')
                 ->descriptionIcon('heroicon-m-arrow-trending-up',IconPosition::Before)
                 ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

             Stat::make('New User',Post::count())//title of card,value of card
                ->description('32k increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up',IconPosition::Before)
                ->color('success')
               ->chart([7,12,3,1,33,1]),

            Stat::make('New User',Category::count())//title of card,value of card
                 ->description('32k increase')
                 ->descriptionIcon('heroicon-m-arrow-trending-up',IconPosition::Before)
                 ->color('success')
                ->chart([2,32,4,1,34,4]),

             Stat::make('New User',Comment::count())//title of card,value of card
                 ->description('32k increase')
                 ->descriptionIcon('heroicon-m-arrow-trending-up',IconPosition::Before)
                 ->color('success')
                ->chart([1,43,32,23,2,23,43,56,24,7])

                
        ];
    }
}
