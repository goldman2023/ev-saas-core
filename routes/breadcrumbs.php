<?php // routes/breadcrumbs.php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// User Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push(translate('Account'), route('dashboard'));
});

// User Products Index
Breadcrumbs::for('ev-products.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(translate('Products'), route('ev-products.index'));
});

// User Products Index
Breadcrumbs::for('ev-products.create', function (BreadcrumbTrail $trail) {
    $trail->parent('ev-products.index');
    $trail->push(translate('Add New Product'), route('ev-products.create'));
});
