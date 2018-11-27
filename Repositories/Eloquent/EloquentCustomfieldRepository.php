<?php

namespace Modules\Iprofile\Repositories\Eloquent;

use Modules\Iprofile\Entities\Customfield;
use Modules\Iprofile\Repositories\CustomfieldRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentCustomFieldRepository extends EloquentBaseRepository implements CustomfieldRepository
{
    /**
     * @inheritdoc
     */
    public function create($data)
    {
        return $this->model->create($data);
    }

    /**
     * @inheritdoc
     */
    public function update($model, $data)
    {
        $model->update($data);

        return $model;
    }

    /**
     * @inheritdoc
     */
    public function destroy($model)
    {
        return $model->delete();
    }
    /**
     * Find a customfield by its name
     * @param $customfieldName
     * @return mixed
     */
    public function findByName($customfieldName)
    {
        return $this->model->where('name', $customfieldName)->first();
    }

    /**
     * Create a customfield with the given name
     * @param $customfields
     * @return void
     */

    public function createOrUpdate($customfields)
    {
        foreach ($customfields as $customfieldName=>$customfieldValues) {
            $customfieldName=$customfieldValues->name;
           if ($customfield = $this->findByName($customfieldName)) {
                $this->update($customfield, $customfieldValues);
                continue;
            }
            $this->create($customfieldValues);
        }
    }
}
