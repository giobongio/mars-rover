<?php

namespace App\Repositories;

use App\Data\Position;
use App\Enums\Direction;
use App\Models\PositionModel;

/**
 * @template-implements ReadRepositoryInterface<Position>
 */
class PositionRepository implements ReadRepositoryInterface, WriteRepositoryInterface
{
    public function get(int $id): ?Position
    {
        $positionModel = PositionModel::find($id);

        if (!$positionModel || !$positionModel->exists) {
            return null;
        }

        return $this->convertModelToData($positionModel);
    }

    /**
     * @param Position $position
     *
     * @return void
     */
    public function save($position): void
    {
        $positionModel = $this->convertDataToModel($position);
        $positionModel->save();
    }

    private function convertDataToModel(Position $position): PositionModel
    {
        return new PositionModel([
            'x' => $position->x,
            'y' => $position->y,
            'direction' => $position->direction->value,
        ]);
    }

    private function convertModelToData(PositionModel $positionModel): Position
    {
        return new Position(
            $positionModel['x'],
            $positionModel['y'],
            Direction::getEnum($positionModel['direction'])
        );
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void
    {
        $positionModel = PositionModel::find($id);

        if ($positionModel && $positionModel->exists) {
            $positionModel->delete();
        }
    }
}
