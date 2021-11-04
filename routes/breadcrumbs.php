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
 * Catalog
 */
Breadcrumbs::for('admin.catalog.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home')->push('Каталог', route('admin.catalog.index'));
});

/**
 * Catalog.Offers
 */
Breadcrumbs::for('admin.catalog.offers.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.catalog.index')->push('Товары', route('admin.catalog.offers.index'));
});

/**
 * Catalog.Categories
 */
Breadcrumbs::for('admin.catalog.categories.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.catalog.index')->push('Категории', route('admin.catalog.categories.index'));
});
Breadcrumbs::for('admin.catalog.categories.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.catalog.categories.index')->push('Создать', route('admin.catalog.categories.create'));
});
Breadcrumbs::for('admin.catalog.categories.edit', function (BreadcrumbTrail $trail, $category) {
    $trail->parent('admin.catalog.categories.index')->push('Изменить', route('admin.catalog.categories.edit', $category));
});

/**
 * Feeds
 */
Breadcrumbs::for('admin.feeds.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home')->push('Фиды', route('admin.feeds.index'));
});
Breadcrumbs::for('admin.feeds.report', function (BreadcrumbTrail $trail, $shop) {
    $trail->parent('admin.feeds.index')->push($shop->name, route('admin.feeds.report', $shop));
});
Breadcrumbs::for('admin.feeds.offers', function (BreadcrumbTrail $trail, $shop) {
    $trail->parent('admin.feeds.index')->push($shop->name, route('admin.feeds.offers', $shop));
});
Breadcrumbs::for('admin.feeds.categories', function (BreadcrumbTrail $trail, $shop) {
    $trail->parent('admin.feeds.index')->push($shop->name, route('admin.feeds.categories', $shop));
});
Breadcrumbs::for('admin.feeds.report.group-deviation', function (BreadcrumbTrail $trail, $shop, $report) {
    $trail->parent('admin.feeds.report', $shop)->push('Отклонения групп', route('admin.feeds.report.group-deviation', [$shop, $report]));
});
