<?php

namespace App\Repositories;

use App\Data\PositionData;
use App\Data\PositionDataBuilder;
use App\Enums\Direction;
use App\Models\PositionModel;

/**
 * @template-implements ReadRepositoryInterface<PositionData>
 */
class PositionRepository implements ReadRepositoryInterface, WriteRepositoryInterface
{
    public function get(int $id): ?PositionData
    {
        $positionModel = PositionModel::find($id);

        if (!$positionModel || !$positionModel->exists) {
            return null;
        }

        return $this->convertModelToData($positionModel);
    }

    /**
     * @param PositionData $positionData
     *
     * @return void
     */
    public function save($positionData): void
    {
        $positionModel = $this->convertDataToModel($positionData);
        $positionModel->save();
    }

    private function convertDataToModel(PositionData $positionData): PositionModel
    {
        return new PositionModel([
            'x' => $positionData->x,
            'y' => $positionData->y,
            'direction' => $positionData->direction->value,
        ]);
    }

    private function convertModelToData(PositionModel $positionModel): PositionData
    {
        return (new PositionDataBuilder())
            ->setX($positionModel['x'])
            ->setY($positionModel['y'])
            ->setDirection(Direction::getEnum($positionModel['direction']))
            ->build();
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
