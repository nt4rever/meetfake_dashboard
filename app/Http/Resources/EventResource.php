<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->edit == "false" ? 1 : 2,
            'title' => $this->title,
            'start' => $this->start == null ? "" : $this->start,
            'end' => $this->end == null ? "" : $this->end,
            'url' => $this->url == null ? "" : $this->url,
            'daysOfWeek' => $this->daysOfWeek == null ? "" : $this->daysOfWeek,
            'backgroundColor' => $this->backgroundColor == null ? "" : $this->backgroundColor,
            'borderColor' => $this->borderColor == null ? "" : $this->borderColor,
        ];
    }
}
