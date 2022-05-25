<form class="w-full flex py-8 px-5" x-data="{
    role: @js($role),
}" wire:submit.prevent="sendInvite()">
    <div class="w-full flex flex-col justify-content items-center"
            wire:loading.class="opacity-30 pointer-events-none"
            wire:target="sendInvite">
        @svg('heroicon-o-user-group', ['class' => 'w-10 mb-4'])
        <h4 class="mb-1 text-typ-2">{{ translate('Invite a staff member') }}</h4>
        <p class="text-typ-3 mb-6">{{ translate('Invite staff members to your shop.') }}</p>

        <div class="w-full">
            <x-dashboard.form.input field="email" placeholder="{{ translate('Enter staff email') }}" class="mb-2" />
            <x-dashboard.form.select field="role" selected="role" :items="\Permissions::getRoleNames()->keyBy(fn($item) => $item)" :nullable="false" class="mb-3" />

            <button type="submit" @click="$wire.set('role', role, true);" class="w-full btn-primary cursor-pointer justify-center">
                {{ translate('Send an invite') }}
            </button>
        </div>
    </div>
</form>