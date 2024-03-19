<?php
    $buttonClass = "flex bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded";    
    if (isset($class)) {
        $buttonClass = $class;
    }
    $buttonActiveClass = $buttonClass;
    if (isset($activeClass)) {
        $buttonActiveClass = $activeClass;
    }

    $buttonTitle = "";
    if (isset($title)) {
        $buttonTitle = $title;
    }
    $buttonActiveTitle = $buttonTitle;
    if (isset($activeTitle)) {
        $buttonActiveTitle = $activeTitle;
    }

    $buttonIcon = "";
    if (isset($icon)) {
        $buttonIcon = $icon;
    }
    $buttonActiveIcon = $buttonIcon;
    if (isset($activeIcon)) {
        $buttonActiveIcon = $activeIcon;
    }

?>
<button wire:click="onClick" class="@if(isset($reaction)) {{ $buttonActiveClass }} @else {{ $buttonClass }} @endif">    
    <span class="flex items-center justify-center truncate">
        <x-heroicon-o-arrow-path wire:loading wire:target="onClick" class="h-6 w-6 animate-spin"/>   
        @isset($buttonIcon)
            <div wire:loading.class="hidden" wire:target="onClick">                
                @isset($reaction)
                    @svg('heroicon-o-'.$buttonActiveIcon, 'h-6 w-6')
                @else 
                    @svg('heroicon-o-'.$buttonIcon, 'h-6 w-6')
                @endisset
            </div>
        @endisset
        @isset($buttonTitle)
            <div class="ml-2 truncate">        
                @isset($reaction)
                    <span>{{ $buttonActiveTitle }}</span>
                @else 
                    <span>{{ $buttonTitle }}</span>
                @endisset
            </div>
        @endisset
        @if($showCount && $count > 0)
            <div class="ml-2"> 
                <span>{{ number_format($count) }}</span>
            </div>
        @endif
    </span>
</button>
