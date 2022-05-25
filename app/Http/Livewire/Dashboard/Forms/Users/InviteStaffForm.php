<?php

namespace App\Http\Livewire\Dashboard\Forms\Users;

use App\Models\User;
use App\Models\UserInvite;
use App\Enums\UserTypeEnum;
use App\Traits\Livewire\RulesSets;
use App\Traits\Livewire\DispatchSupport;
use DB;
use Uuid;
use Livewire\Component;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserInviteNotification;
use Str;
use URL;
use MyShop;

class InviteStaffForm extends Component
{
    use RulesSets;
    use DispatchSupport;

    public $email;
    public $role;

    protected function rules()
    {
        return [
            'email' => ['required', 'email:rfc,dns'],
            'role' => ['required']
        ];
    }

    protected function messages()
    {
        return [
            'email.required' => translate('Email of invitee is required'),
            'email.email' => translate('Not a valid email address'),
            'role.required' => translate('Role is required'),
            
        ];;
    }

    /**
     * Create a new component instance.
     *
     * @param mixed|null $user
     * @param string $class
     * @return void
     */
    public function mount()
    {
       
    }

    public function dehydrate()
    {
        // $this->dispatchBrowserEvent('init-form');
    }

    public function sendInvite()
    {
        $this->validate();

        $user = User::where('email', $this->email)->first();

        do {
            $token = Uuid::generate(4)->string;
        } while (UserInvite::where('token', $token)->first());

        DB::beginTransaction();

        try {
            $invite = UserInvite::create([
                'token' => $token,
                'email' => $this->email,
                'user_id' => auth()->user()->id,
                'shop_id' => MyShop::getShopID(),
                'new_user_type' => UserTypeEnum::staff()->value,
                'new_user_role' => $this->role
            ]);
    
            $url = URL::temporarySignedRoute(
                'user.invite.registration', now()->addMinutes(7 * 1440), ['token' => $token] // expires after 7 days
            );

            DB::commit();

            Notification::route('mail', $this->email)->notify(new UserInviteNotification($invite, $url));

            $this->inform(translate('Invite successfully sent!'), '', 'success');
        } catch(\Exception $e) {
            DB::rollback();
            $this->inform(translate('Error: Invite not sent sent!'), translate('Please contact support to identify and fix the problem.'), 'fail');
        }
        

    }

    public function render()
    {
        return view('livewire.dashboard.forms.users.invite-staff-form');
    }
}
