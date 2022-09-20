<?php
namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Support\Str;

trait Sluggable
{
    protected string $slugColumn;
    protected bool $slugWithDashes;

    /**
     * @param array<string, mixed> $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->slugColumn = 'slug';
        $this->slugWithDashes = true;
    }

    public function getRouteKeyName(): string
    {
        return $this->slugColumn();
    }

    public function scopeWithSlug(Builder $query, string $slug): Builder
    {
        return $query->where($this->slugColumn(), $slug);
    }

    public static function addSlugColumn(Blueprint $table): ColumnDefinition
    {
        $instance = new static();

        return $table->uuid($instance->slugColumn())
            ->unique();
    }

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (self $model): void {
            $slugColumn = $model->slugColumn();
            if (!$model->isDirty($slugColumn)) {
                $model->{$slugColumn} = $model->getNewSlug();
            }
            if(!$model->user_id)
                $model->user_id = auth()->id();
        });
    }

    protected function slugColumn(): string
    {
        return $this->slugColumn;
    }

    protected function slugWithDashes(): bool
    {
        return $this->slugWithDashes;
    }

    private function getNewSlug(): string
    {
        $value = Str::uuid();;

        if (!$this->slugWithDashes()) {
            $value = $value->getHex();
        }

        return $value->toString();
    }
}
