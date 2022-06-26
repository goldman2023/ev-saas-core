<div>

    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mb-6">

        <x-dashboard.widgets.business.quick-action
        route="orders.index"
        title="{{ translate('Process orders') }}"
        icon="arrow-circle-right"
        description="{{ translate('Stay on top of all new orders') }}"
        > </x-dashboard.widgets.business.quick-action>


        <x-dashboard.widgets.business.quick-action
        route="orders.index"
        title="{{ translate('Create new invoice') }}"
        icon="arrow-circle-right"
        description="{{ translate('Create and send invoice in 1 minute.') }}"
        > </x-dashboard.widgets.business.quick-action>

        <x-dashboard.widgets.business.quick-action
        route="crm.all_customers"
        title="{{ translate('Manage customers') }}"
        icon="user-group"
        description="{{ translate('View and interact with your customers') }}"
        > </x-dashboard.widgets.business.quick-action>

        <x-dashboard.widgets.business.quick-action
        route="orders.index"
        title="{{ translate('Manage products') }}"
        icon="shopping-cart"
        description="{{ translate('Create, analyse and update your products') }}"
        > </x-dashboard.widgets.business.quick-action>




    </div>
</div>
