<?php

namespace App\Repositories;

use App\Data\Obstacle;
use App\Models\ObstacleModel;

/**
 * @template-implements ReadRepositoryInterface<Obstacle>
 */
class ObstacleRepository implements ReadRepositoryInterface, WriteRepositoryInterface
{
    public function get(int $id): ?Obstacle
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
     * @param Obstacle $obstacle
     *
     * @return void
     */
    public function save($obstacle): void
    {
        $obstacleModel = $this->convertDataToModel($obstacle);
        $obstacleModel->save();
    }

    private function convertDataToModel(Obstacle $obstacle): ObstacleModel
    {
        return new ObstacleModel([
            'x' => $obstacle->x,
            'y' => $obstacle->y,
        ]);
    }

    private function convertModelToData(mixed $obstacleModel): Obstacle
    {
        return new Obstacle(
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
