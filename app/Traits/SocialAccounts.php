<?php

namespace App\Traits;

use App\Models\ReviewRelationship;

trait SocialAccounts
{
    public function getSocialAccount($provider_key)
    {
        $account = $this->social_accounts->where('provider', $provider_key)->first();

        return empty($account) ? null : $account;
    }
}
