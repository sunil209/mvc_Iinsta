<?php

namespace Instapage\Components\v70\AuthorBiography;

use Instapage\Models\Component;

class AuthorBiographyModel extends Component
{
    public function getAuthorID() : int
    {
        return (int) ($this->rawParams['authorID'] ?? get_the_author_meta('ID'));
    }

    public function getAuthorName() : string
    {
        return get_the_author_meta('display_name', $this->getAuthorID());
    }

    public function getAuthorBiography() : string
    {
        return get_the_author_meta('user_description', $this->getAuthorID());
    }

    public function getAuthorURL() : string
    {
        return get_author_posts_url($this->getAuthorID());
    }

    public function getAuthorPhoto() : array
    {
        return [
            'regular' =>  get_avatar_url($this->getAuthorID(), ['size' => 100]),
            'retina' =>   get_avatar_url($this->getAuthorID(), ['size' => 200])
        ];
    }

    public function getParamsListToInject() : array
    {
        return [
            'authorName',
            'authorBiography',
            'authorURL',
            'authorPhoto'
        ];
    }
}
