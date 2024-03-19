<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Article;
use App\Models\Artist;
use App\Models\Category;
use App\Models\Company;
use App\Models\Job;
use App\Models\ListItem;
use App\Models\Lists;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\Mention;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Thread;
use App\Models\Notification;
use App\Models\ProfileData;
use App\Models\ProfileField;
use App\Models\ProfileGroup;
use App\Models\Reaction;
use App\Models\Report;
use App\Models\SearchForm;
use App\Models\Tag;
use App\Models\TagItem;
use App\Models\Tweet;
use App\Models\User;
use App\Models\UserActivity;
use App\Models\UserMeta;
use App\Models\Video;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        return [
            // Stat::make('Articles', number_format(Article::count())),
            Stat::make('Artists', number_format(Artist::count())),            
            Stat::make('Categories', number_format(Category::count())),
            // Stat::make('Companies', number_format(Company::count())),
            // Stat::make('Jobs', number_format(Job::count())),
            Stat::make('List Items', number_format(ListItem::count())),
            Stat::make('Lists', number_format(Lists::count())),
            Stat::make('Media', number_format(Media::count())),
            Stat::make('Mentions', number_format(Mention::count())),
            Stat::make('Message Threads', number_format(Thread::count())),
            Stat::make('Messages', number_format(Message::count())),
            Stat::make('Notifications', number_format(Notification::count())),
            Stat::make('Profile Data', number_format(ProfileData::count())),
            Stat::make('Profile Fields', number_format(ProfileField::count())),
            Stat::make('Profile Groups', number_format(ProfileGroup::count())),
            Stat::make('Reactions', number_format(Reaction::count())),
            Stat::make('Reports', number_format(Report::count())),
            Stat::make('Search Forms', number_format(SearchForm::count())),
            Stat::make('Tags', number_format(Tag::count())),
            Stat::make('Tag Items', number_format(TagItem::count())),
            Stat::make('Tweets', number_format(Tweet::count())),
            Stat::make('Users', number_format(User::count())),
            Stat::make('User Activities', number_format(UserActivity::count())),
            Stat::make('User Meta', number_format(UserMeta::count())), 
            Stat::make('Videos', number_format(Video::count())),  
        ];
    }
}
