<?php
// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use App\Models\Category;
use Diglactic\Breadcrumbs\Breadcrumbs;
// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('dashboard.orders', function (BreadcrumbTrail $trail, $order = null, $content_type = null) {

    $trail->push(translate('Dashboard'), route('dashboard'));
    $trail->push(translate('All orders'), route('orders.index'));
    /* TODO: Add blog category */
    if($order) {
        $trail->push(translate('Order #') . $order->id, route('order.details', $order->id));
    }
});
