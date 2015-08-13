<?php
require_once __DIR__ . '/../class-loader.php';

use Slim\Slim;
use App\Resource;

// @todo -- this probably isn't the right place for this
// @todo -- this domain needs to be updated to go live; this should be in a config somewhere
header('Access-Control-Allow-Origin: http://dev-local.skribblez.com:8381');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Accept, X-Requested-With, Content-Type');

$app = new Slim();

// Landing page -- necessary?
$app->get('/', function () {
    // @todo -- remove this
    echo '
        <div style="text-align: center;">
            <img src="http://www.troll.me/images2/grammar-correction-guy/excuse-me-but-gtfo.jpg" />
        </div>
            ';
});

// -- Chapters/Starters
// GET starters
$app->get('/starters(/(:page)(/))', function ($page = 1) {
    $resource = Resource::load('chapter');
    $resource->getStarters($page);
});

// POST starter
$app->post('/starter(/)', function () {
    $resource = Resource::load('chapter');
    $resource->postStarter();
});

// GET chapter
$app->get('/chapter/(:guid)(/)', function ($guid) {
    $resource = Resource::load('chapter');
    $resource->getChapter($guid);
});

// POST chapter
$app->post('/chapter/(:guid)(/)', function ($guid) {
    $resource = Resource::load('chapter');
    $resource->postChapter($guid);
});

// PATCH chapter
$app->patch('/chapter/(:guid)(/)', function ($guid) {
    $resource = Resource::load('chapter');
    $resource->patchChapter($guid);
});

// DELETE chapter
$app->delete('/chapter/(:guid)(/)', function ($guid) {
    $resource = Resource::load('chapter');
    $resource->deleteChapter($guid);
});

// GET chapter path
$app->get('/chapter/(:guid)/path(/)', function ($guid) {
    $resource = Resource::load('chapter');
    $resource->getChapterPath($guid);
});

// -- Comments
// GET comments
$app->get('/chapter/(:guid)/comments(/)', function ($guid) {
    $resource = Resource::load('comment');
    $resource->getComments($guid);
});

// POST comment
$app->post('/chapter/(:guid)/comment(/)', function ($guid) {
    $resource = Resource::load('comment');
    $resource->postComment($guid);
});

// OPTIONS - POST comment
$app->options('/chapter/(:guid)/comment(/)', function($guid) {
    $resource = \App\Resource::load('Comment');
    $resource->options();
});

// PATCH comment
$app->patch('/comment/(:guid)(/)', function ($guid) {
    $resource = Resource::load('comment');
    $resource->patchComment($guid);
});

// DELETE comment
$app->delete('/comment/(:guid)(/)', function ($guid) {
    $resource = Resource::load('comment');
    $resource->deleteComment($guid);
});

// -- Ratings
// POST rating
$app->post('/chapter/(:guid)/rating(/)', function ($guid) {
    $resource = Resource::load('rating');
    $resource->postRating($guid);
});

// PATCH rating
$app->patch('/rating/(:guid)(/)', function ($guid) {
    $resource = Resource::load('rating');
    $resource->patchRating($guid);
});

// Options
$app->options('/:resourceName(/)(:id)', function ($resourceName, $id = null) {
    $rmap = array(
        'starter' => 'Chapter',
        'chapter' => 'Chapter',
        'comment' => 'Comment',
        'rating' => 'Rating',
        'user' => 'User'
    );

    $resource = \App\Resource::load($rmap[$resourceName]);

    if ($resource === null) {
        \App\Resource::response(\App\Resource::STATUS_NOT_FOUND);
    } else {
        $resource->options();
    }
});

// Not found
$app->notFound(function () {
    \App\Resource::response(\App\Resource::STATUS_NOT_FOUND);
});

$app->run();