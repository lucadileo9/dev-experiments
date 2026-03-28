<?php

namespace OOP;

class Playlist
{
    public function __construct(public string $name, public array $songs)
    {
        // Since we are using public properties, we don't need to do anything else here.
        // the properties will be automatically assigned when the object is created.
    }
}
