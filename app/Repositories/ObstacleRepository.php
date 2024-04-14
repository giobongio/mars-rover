<?php

namespace App\Repositories;

use App\Data\ObstacleData;
use App\Models\ObstacleModel;

/**
 * @template-implements ReadRepositoryInterface<ObstacleData>
 */
class ObstacleRepository implements ReadRepositoryInterface, WriteRepositoryInterface
{
    public function get(int $id): ?ObstacleData
    {
        $obstacleModel = ObstacleModel::find($id);

        if (!$obstacleModel || !$obstacleModel->exists) {
            return null;
        }

        return $this->convertModelToData($obstacleModel);
    }

    public function getAll(): array
    {
        $obstacleModels = ObstacleModel::all('x', 'y');
        
        return array_map(function ($obstacleModel) { 
            return $this->convertModelToData($obstacleModel); 
        }, $obstacleModels->toArray());
    }

    /**
     * @param ObstacleData $obstacleData
     *
     * @return void
     */
    public function save($obstacleData): void
    {
        $obstacleModel = $this->convertDataToModel($obstacleData);
        $obstacleModel->save();
    }

    private function convertDataToModel(ObstacleData $obstacleData): ObstacleModel
    {
        return new ObstacleModel([
            'x' => $obstacleData->x,
            'y' => $obstacleData->y,
        ]);
    }

    private function convertModelToData(mixed $obstacleModel): ObstacleData
    {
        return new ObstacleData(
            $obstacleModel['x'],
            $obstacleModel['y']
        );
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void
    {
        $obstacleModel = ObstacleModel::find($id);

        if ($obstacleModel && $obstacleModel->exists) {
            $obstacleModel->delete();
        }
    }
}
