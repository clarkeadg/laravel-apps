<?php
  $record = $getRecord();
  $object = $record->object;
  $object_type = $record->object_type;
  $object_id = $record->object_id;
  $profile = $record->profile;
  $app = 'twitter';
?>

<div>
  @isset($object)
        @if($object_type == 'App\Models\Tweet')
            @livewire('tweets.tweet-item', [
                'app' => $app,
                'item' => $object,
                'hideFooter' => true
            ],key('report-tweet-view-'.$object->id)) 
        @endif
    @else
        @isset($profile)
            <div class="max-w-sm m-auto">
                @include('apps.'.$app.'.cards.profile')
            </div>
        @endisset
    @endisset
</div>