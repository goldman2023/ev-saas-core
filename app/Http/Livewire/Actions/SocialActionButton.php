<?php

namespace App\Http\Livewire\Actions;

use App\Models\Product;
use App\Models\Wishlist;
use App\Models\SocialReaction;
use App\Models\Follow;
use App\Traits\Livewire\DispatchSupport;
use Livewire\Component;
use App\Enums\SocialReactionsEnum;

class SocialActionButton extends Component
{
    use DispatchSupport;

    public $object;

    public $added = false;

    public $model_class;

    public $template = 'default'; // wishlist-button-detailed

    public $available_actions = [
        'reaction' => [
            'action' => 'Reaction',
            'action_success' => 'Reacted',
            'icon' => 'heroicon-o-thumb-up',
            'icon_success' => 'heroicon-s-thumb-up',
            'view' => 'livewire.actions.social-buttons.like-button',
            'class' => SocialReaction::class,
            'log_description' => 'reacted',
            'log_description_inverse' => 'reaction_revoked',
        ],
        'wishlist' => [
            'action' => 'Add to wishlist',
            'action_success' => 'Remove from wishlist',
            'icon' => 'heroicon-o-heart',
            'icon_success' => 'heroicon-s-heart',
            'view' => 'livewire.actions.social-buttons.wishlist-button-detailed',
            'class' => Wishlist::class,
            'log_description' => 'added_to_wishlist',
            'log_description_inverse' => 'removed_from_wishlist',
        ],
        'follow' => [
            'action' => 'Follow',
            'action_success' => 'Following',
            'icon' => 'heroicon-o-user-add',
            'icon_success' => 'heroicon-s-check-circle',
            'view' => 'livewire.actions.social-buttons.follow-button',
            'class' => Follow::class,
            'log_description' => 'followed',
            'log_description_inverse' => 'unfollowed',
        ],
        'save' => [
            'action' => 'Save',
            'action_success' => 'Saved',
            'icon' => 'heroicon-o-bookmark',
            'icon_success' => 'heroicon-s-bookmark',
            'view' => 'livewire.actions.wishlist-button',
            'class' => Wishlist::class,
            'log_description' => 'saved',
            'log_description_inverse' => 'unsaved',
        ],
        'notify' => [
            'action' => 'Enable notification',
            'action_success' => 'Notification enabled',
            'icon' => 'heroicon-o-bell',
            'icon_success' => 'heroicon-s-bell',
            'view' => 'livewire.actions.wishlist-button',
            'class' => Wishlist::class, // TODO: Fix this!
            'log_description' => 'notify',
            'log_description_inverse' => 'unnotify',
        ],
    ];

    public $iconDefault = 'heroicon-o-heart';

    public $iconActive = 'heroicon-s-heart';

    public $action = null;

    public $selectedAction = 'reaction';

    public $type = null;

    public $default_template = 'default';

    public $count = 0;

    public function mount($object, $action = 'reaction', $type = '')
    {
        $this->object = $object;
        $this->model_class = $object::class;
        $this->selectedAction = $action;
        $this->action = $this->available_actions[$action] ?? null;
        $this->type = $type;
        
        if ($action === 'reaction') {
            if(empty($type)) {
                $this->type == SocialReactionsEnum::like()->value;
            }

            $this->count = $this->object?->likes()?->count();
        } else if($action === 'follow') {
            $this->count = $this->object?->followers()?->count() ?? 0;
        }

        $this->added = $this->checkIfExists();

        // if ($action = 'notify') {
            // $this->notification = true;
            // $this->action2 = translate('Notification enabled');
        // }
    }

    public function checkIfExists() {
        if (auth()->user()) {
            $query = app($this->action['class'])::where('subject_id', $this->object->id)
                ->where('subject_type', $this->object::class)
                ->where('user_id', auth()->user()->id);

            if(!empty($this->type)) {
                $query->where('type', $this->type);
            }

            return $query->count() === 1;
        }
    }

    public function render()
    {
        if ($this->default_template == 'default') {
            return view($this->action['view']);
        } else {
            return view('livewire.actions.social-buttons.'.$this->template);
        }
    }

    public function fireSocialAction()
    {
        /* If product exists, toggle the database entry - delete if exists, create if does not exist */
        if (auth()->user()) {
            if ($this->added) {
            
                $query = app($this->action['class'])::where('subject_id', $this->object->id)
                        ->where('subject_type', $this->object::class)
                        ->where('user_id', auth()->user()->id);

                if(!empty($this->type)) {
                    $query->where('type', $this->type);
                }
    
                $query->first()->delete();
                

                $this->emit('removedSocialAction', [
                    'action' => $this->selectedAction,
                    'action_class' => $this->action['class'],
                    'type' => $this->type,
                    'model_id' => $this->object->id,
                    'model_class' => $this->object::class
                ]);

                $this->count--;
            } else {
                $social_model = app($this->action['class']);
                $social_model->user_id = auth()->user()->id;
                $social_model->subject_id = $this->object->id;
                $social_model->subject_type = $this->object::class;
                $social_model->created_at = time();

                if(!empty($this->type)) {
                    $social_model->type = $this->type;
                }

                $social_model->save();


                // /* TODO: I think notifications should be defined in events on Wishlist item created outside of controller/component logic
                //     so we can have clear entry points for all notificaitons */
                //     // $this->object->user->notify(new WishlistItemAdded($item));
                
                activity()
                ->performedOn($social_model->subject)
                ->causedBy(auth()->user())
                ->withProperties([
                    'action' => $this->selectedAction,
                    'type' => $this->type,
                    // 'action_title' => 'liked a product',
                ])
                ->log($this->action['log_description']);

                $this->count++;
                
                $this->emit('addedSocialAction', [
                    'action' => $this->selectedAction,
                    'action_class' => $this->action['class'],
                    'type' => $this->type,
                    'model_id' => $this->object->id,
                    'model_class' => $this->object::class
                ]);
            }
        }

        // If Ation is Add to wishlist or Save, send a JS event to change the count of wishlist
        if($this->selectedAction === 'wishlist' || $this->selectedAction === 'save') {
            $this->dispatchBrowserEvent('refresh-wishlist-items-count', ['count' => auth()->user()?->wishlists()?->count()]);
        } else if($this->selectedAction === 'reaction' || $this->selectedAction === 'follow') {
            $this->dispatchBrowserEvent('refresh-social-action-count', [
                'action' => $this->selectedAction,
                'type' => $this->type,
                'model_id' => $this->object->id,
                'model_class' => $this->object::class,
                'count' => $this->count
            ]);
        }

        $this->added = $this->checkIfExists();
    }
}
