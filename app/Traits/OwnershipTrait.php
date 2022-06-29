<?php

namespace App\Traits;

use App\Models\Ownership;
use App\Models\Plan;
use App\Models\Product;
use App\Models\WeQuiz;

trait OwnershipTrait
{
    public function owned_assets() {
        return $this->hasMany(Ownership::class, 'owner_id')->where('owner_type', $this::class)->with(['subject']);
    }

    public function bought($model) {
        if($this?->isAdmin() ?? null) {
            return true;
        }

        if($this?->manages($model) ?? null) {
            return true;
        }

        return $this->owned_assets()->where([
            ['subject_id', $model->id],
            ['subject_type', $model::class]
        ])->exists();
    }

    public function manages($model) {
        if($this?->isAdmin() ?? null) {
            return true;
        }

        if(\Auth::check() && $this->hasShop()) {
            if($model instanceof Product) {
                return $model?->user_id === $this->id || $model?->shop_id === \MyShop::getShopID();
            } else if($model instanceof Plan) {
                return $model?->shop_id === \MyShop::getShopID();
            } else if($model instanceof WeQuiz) {
                return $model?->user_id === $this->id;
            }
        }

        return false;
    }
}