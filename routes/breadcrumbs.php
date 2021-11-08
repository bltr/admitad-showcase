<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

/**
 * Admin home
 */
Breadcrumbs::for('admin.home', function (BreadcrumbTrail $trail) {
    $trail->push('<i class="bi bi-house"></i>', route('admin.home'));
});

/**
 * Offers
 */
Breadcrumbs::for('admin.offers.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.index')->push('Товары', route('admin.offers.index'));
});

/**
 * Categories
 */
Breadcrumbs::for('admin.categories.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.index')->push('Категории', route('admin.categories.index'));
});
Breadcrumbs::for('admin.categories.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.categories.index')->push('Создать', route('admin.categories.create'));
});
Breadcrumbs::for('admin.categories.edit', function (BreadcrumbTrail $trail, $category) {
    $trail->parent('admin.categories.index')->push('Изменить', route('admin.categories.edit', $category));
});

/**
 * Feeds
 */
Breadcrumbs::for('admin.feeds.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home')->push('Фиды', route('admin.feeds.index'));
});
Breadcrumbs::for('admin.feeds.import-grouping', function (BreadcrumbTrail $trail, $shop) {
    $trail->parent('admin.feeds.index')->push($shop->name, route('admin.feeds.import-grouping', $shop));
});
Breadcrumbs::for('admin.feeds.import-mapping', function (BreadcrumbTrail $trail, $shop) {
    $trail->parent('admin.feeds.index')->push($shop->name, route('admin.feeds.import-mapping', $shop));
});
Breadcrumbs::for('admin.feeds.offers', function (BreadcrumbTrail $trail, $shop) {
    $trail->parent('admin.feeds.index')->push($shop->name, route('admin.feeds.offers', $shop));
});
Breadcrumbs::for('admin.feeds.categories', function (BreadcrumbTrail $trail, $shop) {
    $trail->parent('admin.feeds.index')->push($shop->name, route('admin.feeds.categories', $shop));
});
Breadcrumbs::for('admin.feeds.report.group-deviation', function (BreadcrumbTrail $trail, $shop) {
    $trail->parent('admin.feeds.report', $shop)->push('Отклонения групп', route('admin.feeds.report.group-deviation', $shop));
});
