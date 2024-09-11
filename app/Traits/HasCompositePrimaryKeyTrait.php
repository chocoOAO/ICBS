<?php
namespace App\Traits;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;


trait HasCompositePrimaryKeyTrait
{

    /**
     * 获取指示标识是否在增加的值.
     *
     * @return bool
     */
    public function getIncrementing(): bool
    {
        return false;
    }

/**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery($query): Builder
    {
        foreach ($this->getKeyName() as $key) {
            if (isset($this->$key))
                $query->where($key, '=', $this->$key);
            else
                throw new \Exception(__METHOD__ . 'Missing part of the primary key: ' . $key);
        }

        return $query;
    }

    /**
     * Get the primary key value for a save query.
     *
     * @param mixed $keyName
     * @return mixed
     */
    // protected function getKeyForSaveQuery($keyName = null)
    // {
    //     if(is_null($keyName)){
    //         $keyName = $this->getKeyName();
    //     }

    //     if (isset($this->original[$keyName])) {
    //         return $this->original[$keyName];
    //     }

    //     return $this->getAttribute($keyName);
    // }

    // public static function find(array $ids, array $columns = ['*'])
    // {
    //     $model = new self;
    //     $query = $model->newQuery();
    //     // dd($model->getKeyName());
    //     foreach ($model->getKeyName() as $key)
    //     {
    //         $query->where($key, '=', $ids[0]);
    //     }

    //     return $query->first($columns);
    // }

    // public static function findOrFail(array $ids, array $columns = ['*'])
    // {
    //     $model = new self;
    //     $query = $model->newQuery();

    //     foreach ($model->getKeyName() as $key)
    //     {
    //         $query->where($key, '=', $ids[0]);
    //     }

    //     $result = $query->first($columns);

    //     if (!$result) {
    //         throw new ModelNotFoundException();
    //     }

    //     return $result;
    // }


}
