<?php
namespace App\Http\Controllers;
use App\Models\Chapter;

class ChapterController extends Controller {

    /**
     * Chapter number
     * @var int
     */
    protected $number;

    /**
     * Author id (GUID)
     * @var string
     */
    protected $author_id;

    /**
     * Chapter body
     * @var string
     */
    protected $body = '';

    /**
     * Parent/chapter 1 id (GUID)
     * @var string
     */
    protected $parent_id = null;

    /**
     * Previous chapter id (GUID)
     * @var string
     */
    protected $prev_id = null;

    /**
     * Chapter title
     * @var string
     */
    protected $title = null;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @todo
     */
    public function getChapter()
    {
        $chapters = Chapter::all();
//         echo '<pre>';
//         print_r($chapters);
//         echo '</pre>';

//         foreach ($chapters as $c) {
        $ccount = count($chapters);
        for ($i = 0; $i < $ccount; $i++) {
            $c = $chapters[$i];
            echo '<pre>';
            print_r($c->_guid . $c->body);
            echo '</pre>';
//             $c->delete();
        }

//         $chapter = new Chapter();
//         $chapter->setAttribute('number', 1);
//         $chapter->setAttribute('author_id', 'author2');
//         $chapter->setAttribute('body', 'another test chapter');
//         $chapter->setAttribute('title', 'story title');

//         echo '<pre>';
//         print_r($chapter->body);
//         echo '</pre>';

//         $chapter->save();
    }

}
