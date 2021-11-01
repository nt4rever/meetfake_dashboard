<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
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
            'id' => 1,
            'title' => $this->title,
            'start' => $this->start == null ? "" : $this->start,
            'end' => $this->end == null ? "" : $this->end,
            'startTime' => $this->startTime == null ? "" : $this->startTime,
            'endTime' => $this->endTime == null ? "" : $this->endTime,
            'url' => "/r/" . $this->roomId,
            'allDay' => "",
            'daysOfWeek' => $this->daysOfWeek == null ? "" : $this->daysOfWeek,
            'backgroundColor' => "#3c8dbc",
            'borderColor' => "#3c8dbc",
        ];
    }
}
