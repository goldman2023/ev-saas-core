<div class="w-full flex py-8 px-5" x-data="{
            
}">
    <div class="w-full flex flex-col justify-content items-center">
        @svg('heroicon-o-user-group', ['class' => 'w-10 mb-4'])
        <h4 class="mb-1 text-typ-2">{{ translate('Invite a staff member') }}</h4>
        <p class="text-typ-3 mb-6">{{ translate('Invite staff members to your shop.') }}</p>

        <div class="w-full">
            <x-dashboard.form.input field="" placeholder="{{ translate('Enter staff email') }}" class="mb-3" />
            <div class="w-full btn-primary cursor-pointer justify-center">
                {{ translate('Send an invite') }}
            </div>
        </div>
    </div>
</div>