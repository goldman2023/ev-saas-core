<?php

namespace App\Http\Livewire\Feed\Elements;

use App\Models\BlogPost;
use DOMDocument;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
// use App\Models\Bookmark as BookmarkModel;
use Illuminate\Http\Client\ConnectionException;

class Bookmark extends Component
{
    public string $link = '';
    public string $title = '';
    public string $image = '';
    public string $description = '';
    public string $message = '';

    protected $rules = [
        'title' => ['required', 'string'],
        'link' => ['required', 'url']
    ];

    public function updatedLink()
    {
        $this->validateOnly('link');


        $content = file_get_contents($this->link);

        $doc = new DOMDocument();

        // squelch HTML5 errors
        @$doc->loadHTML($content);

        $meta = $doc->getElementsByTagName('meta');
        $tags = [];
        foreach ($meta as $element) {
            foreach ($element->attributes as $node) {
                $tags[$node->name] = $node->value;
            }
            // $tags[] = $tag;
        }

        // dd($tags);

        // $tags = get_meta_tags($this->link);
        // $this->image = $tags['twitter:image'];
        // $this->title = $tags['twitter:title'];
        // $this->description = $tags['twitter:description'];

        try {
            $response = Http::get($this->link);

            if ($response->status() == 200) {
                preg_match_all("/<title>(.+)<\/title>/siU", $response, $title);
                $this->title = $title[1][0];

                preg_match_all('/<\s*meta\s+property="og:image"\s+content="([^"]*)/i', $response, $image);
                $this->image = $image[1][0] ?? '/images/no_image.png';

                preg_match_all('/<\s*meta\s+name="description"\s+content="([^"]*)/i', $response, $description);
                $this->description = $description[1][0] ?? '';



                $this->reset('message');
            }
        } catch (ConnectionException $e) {
            $this->reset('title', 'image', 'description');

            $this->message = 'Could not get link data';
        }
    }

    public function render()
    {
        $bookmarks = BlogPost::latest('id')->take(5)->get();

        return view('livewire.feed.elements.bookmark', compact('bookmarks'));
    }

    public function storeBookmark()
    {
        $this->validate();

        BookmarkModel::create([
            'title' => $this->title,
            'link' => $this->link,
        ]);

        $this->reset(['link', 'title', 'image', 'description', 'message']);
    }
}
