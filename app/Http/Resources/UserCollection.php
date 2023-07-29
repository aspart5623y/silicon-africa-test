<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        [$from, $to, $links] = pagination($this->path(), $this->currentPage(), $this->perPage(), $this->lastPage(), $this->total());

        return [
            'data' => $this->collection,
            'links' => $links,
            "current_page" => $this->currentPage(),
            "from" => $from,
            "to" => $to,
            "last_page" => $this->lastPage(),
            "per_page" => $this->perPage(),
            "total" => $this->total()
        ];
    }
}
