<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NoteStrikeFirstCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public $collects = 'App\Http\Resources\NoteStrikeFirstResource';

    public function toArray($request){

        return $this->collection;
    }
}
