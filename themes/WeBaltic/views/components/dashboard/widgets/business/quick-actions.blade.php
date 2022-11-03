<div>

    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mb-6">

        <x-dashboard.widgets.business.quick-action
        route="orders.index"
        title="{{ translate('Process orders') }}"
        icon="arrow-circle-right"
        description="{{ translate('Stay on top of all new orders') }}"
        > </x-dashboard.widgets.business.quick-action>

        @if(auth()->user()->isAdmin())

        <x-dashboard.widgets.business.quick-action
        route="orders.index"
        title="{{ translate('Create new order') }}"
        icon="arrow-circle-right"
        description="{{ translate('New manufacturing order') }}"
        > </x-dashboard.widgets.business.quick-action>
        @endif

        @if(auth()->user()->isAdmin())
        <x-dashboard.widgets.business.quick-action
        route="crm.all_customers"
        title="{{ translate('Manage customers') }}"
        icon="user-group"
        description="{{ translate('View and interact with your customers') }}"
        > </x-dashboard.widgets.business.quick-action>
        @endif

        <x-dashboard.widgets.business.quick-action
        route="products.index"
        title="{{ translate('Manage products') }}"
        icon="shopping-cart"
        description="{{ translate('Create, analyse and update your products') }}"
        > </x-dashboard.widgets.business.quick-action>




    </div>
</div>
