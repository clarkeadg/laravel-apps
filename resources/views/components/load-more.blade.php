<div class="ui-load-more">
    <div
        x-data="{
            observe () {
                let observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            @this.call('loadMore')
                        }
                    })
                }, {
                    root: null
                })

                observer.observe(this.$el)
            }
        }"
        x-init="observe"
    ></div>
    <div class="flex justify-center">
        <div wire:loading>
            <x-heroicon-o-arrow-path class="h-8 w-8 text-blue-500 animate-spin"/>
        </div>
        <button wire:loading.class="hidden" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" wire:click.prevent="loadMore">
            Load more
        </button>
    </div>
</div>
