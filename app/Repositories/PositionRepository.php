<?php

namespace App\Repositories;

use App\Data\PositionData;
use App\Data\PositionDataBuilder;
use App\Enums\RoverDirection;
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
        $positionModel = PositionModel::find($positionData->id);

        if (!$positionModel || !$positionModel->exists) {
            $positionModel = $this->convertDataToModel($positionData);
        }

        $positionModel->save();
    }

    private function convertDataToModel(PositionData $positionData): PositionModel
    {
        return new PositionModel([
            'point_x' => $positionData->pointX,
            'point_y' => $positionData->pointY,
            'rover_direction' => $positionData->roverDirection,
        ]);
    }

    private function convertModelToData(PositionModel $positionModel): PositionData
    {
        return (new PositionDataBuilder())
            ->setPointX($positionModel['point_x'])
            ->setPointY($positionModel['point_y'])
            ->setRoverDirection(RoverDirection::getNameFromValue($positionModel['rover_direction']))
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
