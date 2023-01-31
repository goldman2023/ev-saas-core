<div class=" overflow-x-auto mb-6">

    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="sm:grid grid-cols-1 gap-3 sm:grid-cols-2 flex overflow-auto">

        <x-dashboard.widgets.business.quick-action
        route="orders.index"
        title="{{ translate('Process orders') }}"
        icon="arrow-right-circle"
        description="{{ translate('Stay on top of all new orders') }}"
        > </x-dashboard.widgets.business.quick-action>

        @if(auth()->user()->isAdmin())

        <x-dashboard.widgets.business.quick-action
        route="orders.index"
        title="{{ translate('Create new order') }}"
        icon="arrow-right-circle"
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
