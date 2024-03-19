<div class="inline-flex justify-center items-center px-1">
    @if($online == true)
        <div title="Online" class="w-3 h-3 rounded-full bg-green-400 inline-flex items-center justify-center">

        </div>
    @endif
    @if($online == false)
        <div title="Offline" class="w-3 h-3 rounded-full bg-red-400 inline-flex items-center justify-center">

        </div>
    @endif
</div>
