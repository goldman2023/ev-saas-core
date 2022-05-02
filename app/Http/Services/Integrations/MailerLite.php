<?php

namespace App\Http\Services\Integrations;

use Log;
use Illuminate\Support\Str;

class MailerLite
{
    public $mailerlite;

    public function __construct()
    {
        $mailerlite_api_key = get_tenant_setting('mailerlite_api_token', null);

        if(!empty($mailerlite_api_key)) {
            try {
                $this->mailerlite = new \MailerLiteApi\MailerLite($mailerlite_api_key); // init mailerlite client
            } catch(\Exception $e) {
                Log::error($e->getMessage());
            }
        } else {
            $this->mailerlite = null;
        } 
    }

    public function fetch() {
        try {
            return $this->mailerlite;
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        } 
    }

    public function hasToken() {
        return !empty(get_tenant_setting('mailerlite_api_token', null));
    }

    /**
     * This function returns all MailerLite groups as a laravel Collection.
     *
     * Also, it creates Default WeSaas Mailing Lists defined inside `\App\Enums\WeMailingListsEnum` class,
     * as Mailerlite groups (if these groups don't exists already)
     */
    public function getGroups() {
        try {
            $we_mailing_groups = \App\Enums\WeMailingListsEnum::labels();
            $mailerlite_groups_api = $this->mailerlite->groups();
            $mailerlite_groups = collect($mailerlite_groups_api->get()->toArray());

            foreach($we_mailing_groups as $key => $label) {
                // If any WeSaaS default Mailing list doesn't exist in Mailerlite, create it!
                if($mailerlite_groups->where('name', $label)->count() <= 0) {
                    $mailerlite_groups_api->create(['name' => $label]);
                }
            }

            return collect($mailerlite_groups_api->get()->toArray());
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * This function returns a specific MailerLite group by name or ID.
     *
     * @param mixed $identifier - can be group name or ID
     */
    public function getGroup($identifier) {
        try {
            $groups = $this->getGroups();

            // Try by name andthen by ID
            if(empty($group = $groups->where('name', $identifier)->first())) {
                $group = $groups->where('id', $identifier)->first();
            }

            return $group;
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function getSubscriber($user) {
        try {
            if(is_string($user)) {
                return $this->mailerlite->subscribers()->search($user)[0] ?? null;
            } else {
                return $this->mailerlite->subscribers()->search($user->email ?? '')[0] ?? null;
            }
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function addSubscriberToGroup($group_identifier, $user) {
        try {
            $group = $this->getGroup($group_identifier);

            $fields = [
                'company' => '',
                'city' => '',
                'state' => '',
                'country' => '',
                'z_i_p' => '',
                'phone' => $user->phone ?? '',
                'last_name' => $user->surname ?? '',
                'name' => $user->name ?? '',
            ];

            // Append WeSaaS Default subscriber fields!
            $we_mailing_fields = \App\Enums\WeMailingSubsribersFieldsEnum::values();
            foreach($we_mailing_fields as $title => $type) {
                $fields[Str::snake($title)] = '';
            }

            $subscriber = $this->mailerlite->groups()->addSubscriber($group->id, [
                'email' => $user->email,
                'name' => $user->name.' '.$user->surname,
                'type' => 'active',
                'fields' => $fields
            ]);

            return $subscriber;
        } catch(\Exception $e) {
            // TODO: Discern between different Response error codes...
            Log::error($e->getMessage());
        }

        return false;
    }

    public function getFields() {
        try {
            return collect($this->mailerlite->fields()->get()->toArray());
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function addDefaultFields() {
        try {
            $we_mailing_fields = \App\Enums\WeMailingSubsribersFieldsEnum::values();
            $mailerlite_fields = $this->getFields();
            
            foreach($we_mailing_fields as $title => $type) {
                if($mailerlite_fields->where('title', $title)->count() <= 0) {
                    $this->mailerlite->fields()->create([
                        'title' => $title,
                        'type' => $type
                    ]);
                }
            }

            return true;
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
