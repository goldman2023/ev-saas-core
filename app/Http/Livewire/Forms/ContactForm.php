<?php

namespace App\Http\Livewire\Forms;

use App\Models\Address;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Traits\Livewire\DispatchSupport;
use App\Traits\Livewire\RulesSets;
use Auth;
use Carbon;
use Categories;
use DB;
use EVS;
use MailerService;
use App\Enums\WeMailingListsEnum;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Spatie\ValidationRules\Rules\ModelsExist;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Admin\ContactNotification;
use Str;
use Log;

class ContactForm extends Component
{
    use DispatchSupport;

    public $first_name;
    public $last_name;
    public $email;
    public $subject;
    public $message;
    public $phone;
    public $consent = false;

    protected function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email:rfc,dns',
            'phone' => 'nullable',
            'subject' => 'required',
            'message' => 'required',
            'consent' => ['required', 'boolean', 'is_true'],
        ];
    }

    protected function messages()
    {
        return [
            'email.required' => translate('Email is required'),
            'email.email' => translate('Not a valid email address'),
            'first_name.required' => translate('First name is required'),
            'last_name.required' => translate('Last name is required'),
            'subject.required' => translate('Subject is required'),
            'message.required' => translate('Message is required'),
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
        return view('livewire.forms.contact-form');
    }

    public function contactUs()
    {
        $this->validate();

        $to = get_tenant_setting('site_contact_email');

        if(empty($to)) {
            $to = \App\Models\User::where('user_type', 'admin')->first()->email ?? '';
        }

        try {
            // Send Contact message to site_contact_email or if that's empty, send to first admin
            Notification::route('mail', $to)
                ->notify(new ContactNotification(
                    first_name: $this->first_name,
                    last_name: $this->last_name,
                    email: $this->email,
                    subject: $this->subject,
                    message: $this->message,
                    phone: $this->phone,
                ));
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }

        $this->inform(translate('You have successfully sent a message'), translate('Representative will contact you soon!'), 'success');

        $this->resetForm();
    }

    public function resetForm() {
        $this->first_name = '';
        $this->last_name = '';
        $this->email = '';
        $this->subject = '';
        $this->message = '';
        $this->phone = '';
    }
}
