<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Job extends Model
{
    use HasFactory;


    public function tag(string $name): void
    {
        $tag = Tag::query()->firstOrCreate(['name' => $name]);

        $this->tags()->attach($tag);
    }

    public function tags()
    {

        return $this->belongsToMany(Tag::class);
    }


    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }
}
