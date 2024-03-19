<?php

namespace App\Livewire\Moderation;

use App\Services\ModerationService;
use App\Services\ReactionService;
use App\Services\TweetService;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class ReportCreate extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public ?string $app = null;

    public ?string $object_type = null;

    public ?int $object_id = null;

    public $object = null;

    public ?int $profile_id = null;

    public ?User $profile = null;

    protected $moderationService;

    protected $reactionService;

    protected $tweetService;

    protected $userService;

    public function boot(
        ModerationService $moderationService,
        ReactionService $reactionService,
        TweetService $tweetService,
        UserService $userService
    )
    {
        $this->moderationService = $moderationService;
        $this->reactionService = $reactionService;
        $this->tweetService = $tweetService;
        $this->userService = $userService;
    }

    public function mount(): void
    {       
        $this->profile = $this->userService->getById($this->profile_id);

        if ($this->object_type == "App\Models\Tweet") {
            $this->object = $this->tweetService->getById($this->object_id);
        }
        
        $this->form->fill([]);
    }

    public function form(Form $form): Form
    {      
        return $form
            ->schema([
                Textarea::make('content')
                    ->rows(3)
                    ->label("Additional comments"),
                Toggle::make('block')->label('Also block @'.$this->profile->name)
            ])
            ->statePath('data');
    }

    public function create(): void
    {        
        $user = Auth::user();
        $state = $this->form->getState();

        // create report
        $report = $this->moderationService->createReport(
            $user->id,
            $this->profile_id,
            $this->object_type,
            $this->object_id,
            $state['content']
        );

        // block user
        if($state['block']) {
            $reaction = $this->reactionService->get(
                $user->id,
                'block',
                'App\Models\User',
                $this->profile_id
            );

            if(!isset($reaction)) {
                $reaction = $this->reactionService->create(
                    $user->id,
                    'block',
                    'App\Models\User',
                    $this->profile_id
                );                
            }
        }

        $this->dispatch('closeModal');
    }
    
    public function render()
    {
        return view('livewire.moderation.report-create');
    }
}
