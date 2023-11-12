<?php

namespace App\Console\Commands;

use App\Models\Programme;
use Exception;
use Illuminate\Console\Command;

/**
 * Credit for the class @dwaard
 */
class UpsertMasterData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:upsert-master-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upserts master data';

    /**
     * The models we want to upsert configuration data for
     *
     * @var array
     */
    private array $master_data = [
        Programme::class => [
            ['id' => 1, 'name' => 'International Business'],
            ['id' => 2, 'name' => 'Information and Communication Technology'],
            ['id' => 3, 'name' => 'Tourism Management'],
            ['id' => 4, 'name' => 'Business Administration'],
            ['id' => 5, 'name' => 'Marketing'],
            ['id' => 6, 'name' => 'Communication'],
            ['id' => 7, 'name' => 'Finance and Control'],
            ['id' => 8, 'name' => 'Human Resource Management'],
            ['id' => 9, 'name' => 'Sport Studies'],
            ['id' => 10, 'name' => 'Industrial Engineering and Management'],
            ['id' => 11, 'name' => 'Chemistry'],
            ['id' => 12, 'name' => 'Logistics engineering'],
            ['id' => 13, 'name' => 'Global Project and Change management'],
            ['id' => 14, 'name' => 'Civil Engineering'],
            ['id' => 15, 'name' => 'Architecture and Construction engineering'],
            ['id' => 16, 'name' => 'Education in Primary Schools'],
            ['id' => 17, 'name' => 'Educational theory'],
            ['id' => 18, 'name' => 'Nursing'],
            ['id' => 19, 'name' => 'Nursing and Midwifery'],
            ['id' => 20, 'name' => 'Social work'],
        ]
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach ($this->master_data as $model => $data) {
            $this->info('Upserting '.$model);
            // check that class exists
            if (!class_exists($model)) {
                throw new Exception('Configuration seed failed. Model does not exist.');
            }

            /**
             * seed each record
             */
            foreach ($data as $row) {
                $record = $this->getRecord($model, $row['id']);
                foreach ($row as $key => $value) {
                    $this->upsertRecord($record, $row);
                }
            }
        }
    }

    /**
     * _fetchRecord - fetches a record if it exists, otherwise instantiates a new model
     *
     * @param string $model - the model
     * @param integer $id    - the model ID
     *
     * @return object - model instantiation
     */
    private function getRecord (string $model, int $id): object
    {
        if ($this->isSoftDeletable($model)) {
            $record = $model::withTrashed()->find($id);
        } else {
            $record = $model::find($id);
        }
        return $record ? $record : new $model;
    }

    /**
     * _upsertRecord - upsert a database record
     *
     * @param object $record - the record
     * @param array $row    - the row of update data
     *
     * @return void
     */
    private function upsertRecord (object $record, array $row): void
    {
        foreach ($row as $key => $value) {
            if ($key === 'deleted_at' && $this->isSoftDeletable($record)) {
                if ($record->trashed() && !$value) {
                    $record->restore();
                } else if (!$record->trashed() && $value) {
                    $record->delete();
                }
            } else {
                $record->$key = $value;
            }
        }
        $record->save();
    }

    /**
     * _isSoftDeletable - Determines if a model is soft-deletable
     *
     * @param string $model - the model in question
     *
     * @return boolean
     */
    private function isSoftDeletable (string $model): bool
    {
        $uses = array_merge(class_uses($model), class_uses(get_parent_class($model)));
        return in_array('Illuminate\Database\Eloquent\SoftDeletes', $uses);
    }
}
