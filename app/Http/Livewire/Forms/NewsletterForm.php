<?php

namespace App\Http\Livewire\Forms;

use App\Models\User;
use App\Traits\Livewire\DispatchSupport;
use MailerService;
use App\Enums\WeMailingListsEnum;
use App\Models\Lead;
use Illuminate\Support\Collection;
use Livewire\Component;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Admin\ContactNotification;
use Str;
use Log;

class NewsletterForm extends Component
{
    use DispatchSupport;

    public $email;
    public $consent = false;

    protected function rules()
    {
        return [
            'email' => 'required|email:rfc,dns',
            'consent' => ['required', 'boolean', 'is_true'],
        ];
    }

    protected function messages()
    {
        return [
            'email.required' => translate('Email is required'),
            'email.email' => translate('Not a valid email address'),
            'consent.required' => translate('Consent is required.'),
            'consent.boolean' => translate('Consent is required.'),
            'consent.is_true' => translate('Consent is required.'),
        ];
    }

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount()
    {
    }

    public function render()
    {
        return view('livewire.forms.newsletter-form');
    }

    public function subscribe()
    {
        $this->validate();
        if(Lead::where('email', $this->email)->count() == 0) {
            $lead = new Lead();
            $lead->email = $this->email;
            $lead->save();
        } else {
            // TODO: Add re-subscribed lead update.
        }


        try {
            // Check if user with provided email exists already
            $user = User::where('email', $this->email)->first();

            if(!empty($user) && $user instanceof User) {
                // User under given email exists
                $subscriber = MailerService::mailerlite()->addSubscriberToGroup(WeMailingListsEnum::newsletter()->label, $user);

                // Set the core_meta 'mailerlite_subscriber_id' flag to 1!
                if(!empty($subscriber)) {
                    $user->core_meta()->updateOrCreate(
                        ['key' => 'mailerlite_subscriber_id'],
                        ['value' => $subscriber->id]
                    );
                }
            } else {
                // User under given email doesn't exist
                $subscriber = MailerService::mailerlite()->addEmailToNewsletterGroup($this->email);
            }
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }

        $this->inform(translate('Thank you for successfully subscribing to our newsletter!'), '', 'success');

        $this->resetForm();
    }

    public function resetForm() {
        $this->email = '';
        $this->consent = false;
    }
}
