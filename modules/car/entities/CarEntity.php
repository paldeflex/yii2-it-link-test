<?php

namespace app\modules\car\entities;

class CarEntity
{
    public ?int $id;
    public string $title;
    public string $description;
    public string $price;
    public string $photoUrl;
    public string $contacts;
    public ?string $createdAt;
    public ?CarOptionEntity $option;

    public function __construct(
        string $title,
        string $description,
        string $price,
        string $photoUrl,
        string $contacts,
        ?CarOptionEntity $option = null,
        ?int $id = null,
        ?string $createdAt = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->photoUrl = $photoUrl;
        $this->contacts = $contacts;
        $this->option = $option;
        $this->createdAt = $createdAt;
    }

    public function toArray(): array
    {
        $data = [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'photo_url' => $this->photoUrl,
            'contacts' => $this->contacts,
            'created_at' => $this->createdAt,
        ];

        $data['options'] = $this->option?->toArray();

        return $data;
    }
}