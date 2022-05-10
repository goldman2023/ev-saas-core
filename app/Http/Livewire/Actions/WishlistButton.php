<?php

namespace App\Http\Livewire\Actions;

use App\Models\Product;
use App\Models\Wishlist;
use App\Notifications\WishlistItemAdded;
use App\Traits\Livewire\DispatchSupport;
use Livewire\Component;

class WishlistButton extends Component
{
    use DispatchSupport;

    public $object;

    public $added = false;

    public $model_class;

    public $template = 'default'; // wishlist-button-detailed

    public $available_actions = [
        'Like' => [
            'action' => 'Like',
            'action_success' => 'Liked',
            'icon' => 'heroicon-o-thumb-up',
            'icon_success' => 'heroicon-s-thumb-up',
            'view' => 'livewire.actions.wishlist-buttons.like-button',
        ],
        'Wishlist' => [
            'action' => 'Add to wishlist',
            'action_success' => 'Remove from wishlist',
            'icon' => 'heroicon-o-heart',
            'icon_success' => 'heroicon-s-heart',
            'view' => 'livewire.actions.wishlist-buttons.wishlist-button-detailed',
        ],
        'Follow' => [
            'action' => 'Follow',
            'action_success' => 'Following',
            'icon' => 'heroicon-o-user-add',
            'icon_success' => 'heroicon-s-check-circle',
            'view' => 'livewire.actions.wishlist-buttons.follow-button',
        ],
        'Save' => [
            'action' => 'Save',
            'action_success' => 'Saved',
            'icon' => 'heroicon-o-bookmark',
            'icon_success' => 'heroicon-s-bookmark',
            'view' => 'livewire.actions.wishlist-button',
        ],
        'Notify' => [
            'action' => 'Enable notification',
            'action_success' => 'Notification enabled',
            'icon' => 'heroicon-o-bell',
            'icon_success' => 'heroicon-s-bell',
            'view' => 'livewire.actions.wishlist-button',
        ],
    ];

    public $iconDefault = 'heroicon-o-heart';

    public $iconActive = 'heroicon-s-heart';

    public $action = 'Like';

    public $selectedAction = 'Like';

    public $default_template = 'default';

    public $count = 0;

    public function mount($object, $action = 'Like', )
    {
        $this->model_class = $object::class;
        $this->selectedAction = $action;
        $this->object = $object;
        $this->added = $this->checkIfProductExistsInWishlist();
        $this->action = $this->available_actions[$action];
        if ($action == 'Like') {
            $this->count = $this->object->likes()->count();
        }
        // if ($action = 'notify') {
            // $this->notification = true;
            // $this->action2 = translate('Notification enabled');
        // }
    }

    public function render()
    {
        if ($this->default_template == 'default') {
            return view($this->action['view']);
        } else {
            return view('livewire.actions.wishlist-buttons.'.$this->template);
        }
    }

    public function addToWishlist()
    {
        if ($this->checkIfProductExistsInWishlist()) {
            /* If product exists, toggle the database entry - delete if exists, create if does not exist */
            if (auth()->user()) {
                $item = Wishlist::where('subject_id', $this->object->id)
                    ->where('subject_type', $this->model_class)
                    ->where('user_id', auth()->user()->id)
                    ->first()->delete();
            } else {
                $item = Wishlist::where('subject_id', $this->object->id)
                    ->where('subject_type', $this->model_class)
                    ->where('guest_id', session()->getId())
                    ->first()->delete();
            }

            $this->emit('removedFromWishlist');
            $this->toastify(translate('Item removed from wishlist'), 'success');
        } else {
            $item = new Wishlist();
            $item->subject_type = $this->model_class;
            $item->subject_id = $this->object->id;
            if (auth()->user()) {
                $item->user_id = auth()->user()->id;
            /* TODO: I think notifications should be defined in events on Wishlist item created outside of controller/component logic
                so we can have clear entry points for all notificaitons */
                // $this->object->user->notify(new WishlistItemAdded($item));
            } else {
                $item->guest_id = session()->getId();
            }
            $item->save();
            
            activity()
                ->performedOn($item->subject)
                ->causedBy(auth()->user())
                ->withProperties([
                    'action' => 'liked',
                    'action_title' => 'liked a product',
                ])
                ->log('liked');

            $this->toastify(translate('Item added to wishlist'), 'success');
            $this->count++;
            $this->emit('addedToWishlist');
        }

        $this->dispatchBrowserEvent('refresh-wishlist-items-count', ['count' => auth()->user()?->wishlists()?->count()]);

        $this->added = $this->checkIfProductExistsInWishlist();
    }

    public function checkIfProductExistsInWishlist()
    {
        if (auth()->user()) {
            return Wishlist::where('subject_id', $this->object->id)
                ->where('subject_type', $this->model_class)
                ->where('user_id', auth()->user()->id)
                ->count() === 1;
        } else {
            return Wishlist::where('subject_id', $this->object->id)
                ->where('subject_type', $this->model_class)
                ->where('guest_id', session()->getId())
                ->count() === 1;
        }
    }
}
