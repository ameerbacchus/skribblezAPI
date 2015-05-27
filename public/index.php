<?php
require_once __DIR__ . '/../class-loader.php';

use Slim\Slim;
use App\Resource;

$app = new Slim();

$app->get('/', function() {
    echo 'landing page';
    // @todo -- remove this or throw an error
});

$app->get('/starters(/(:page)(/))', function($page = 1) {
    $resource = Resource::load('chapter');
    $resource->getStarters($page);
});

$app->post('/starter', function() {
    $resource = Resource::load('chapter');
    $resource->postStarter();
});

$app->get('/chapter/(:guid)(/)', function($guid) {
    $resource = Resource::load('chapter');
    $resource->getChapterDetails($guid);
});

$app->post('/chapter', function() {
    $resource = Resource::load('chapter');
    $resource->postChapter();
});

//-- @todo - slim generated endpoints; DELETE THEM

// Get
$app->get('/:resource(/(:id)(/))', function($resource, $id = null) {
    $resource = \App\Resource::load($resource);
    if ($resource === null) {
        \App\Resource::response(\App\Resource::STATUS_NOT_FOUND);
    } else {
        $resource->get($id);
    }
});

// Post
$app->post('/:resource(/)', function($resource) {
    $resource = \App\Resource::load($resource);
    if ($resource === null) {
        \App\Resource::response(\App\Resource::STATUS_NOT_FOUND);
    } else {
        $resource->post();
    }
});

// Put
$app->put('/:resource/:id(/)', function($resource, $id = null) {
    $resource = \App\Resource::load($resource);
    if ($resource === null) {
        \App\Resource::response(\App\Resource::STATUS_NOT_FOUND);
    } else {
        $resource->put($id);
    }
});

// Delete
$app->delete('/:resource/:id(/)', function($resource, $id = null) {
    $resource = \App\Resource::load($resource);
    if ($resource === null) {
        \App\Resource::response(\App\Resource::STATUS_NOT_FOUND);
    } else {
        $resource->delete($id);
    }
});

// Options
$app->options('/:resource(/)', function($resource, $id = null) {
    $resource = \App\Resource::load($resource);
    if ($resource === null) {
        \App\Resource::response(\App\Resource::STATUS_NOT_FOUND);
    } else {
        $resource->options();
    }
});

// Not found
$app->notFound(function() {
    \App\Resource::response(\App\Resource::STATUS_NOT_FOUND);
});

$app->run();