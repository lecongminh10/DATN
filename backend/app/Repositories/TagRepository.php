<?php

namespace App\Repositories;

use App\Models\Tag;

class  TagRepository extends BaseRepository
{
    protected $tagRepository;

    public function __construct(Tag $tagRepository) {
        parent::__construct($tagRepository);
        $this->tagRepository = $tagRepository;
    }

    public function getIdandNameAll() {
        $data = Tag::query()->pluck('name', 'id')->all();
        return $data;
    }
}