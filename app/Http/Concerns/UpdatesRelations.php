<?php


namespace App\Http\Concerns;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait UpdatesRelations
{

    protected function updateOneToMany (Model $model, string $relation, array $input): bool
    {
        $prop = Str::snake($relation);
        $hasChanges = false;
        if (isset($input[$prop])) {
            $updated = [];
            $new = [];
            foreach ($input[$prop] as $data) {
                if (!empty($data['id'])) {
                    $updated[$data['id']] = $data;
                } else {
                    $new[] = $data;
                }
            }
            //update data of existing items, or remove if not in input
            foreach ($model->$relation as $existingItem) {
                if (isset($updated[$existingItem->id])) {
                    $saved = $existingItem->update($updated[$existingItem->id]);
                    $hasChanges = $hasChanges ?: $saved;
                } else {
                    $hasChanges = true;
                    $existingItem->delete();
                }
            }
            //add the new items
            foreach ($new as $data) {
                $hasChanges = true;
                $model->$relation()->create($data);
            }
        }
        return $hasChanges;
    }
}
