<?php

namespace App\Repositories;
use Illuminate\Support\Facades\Storage;

use Illuminate\Database\Eloquent\Model;
use DB;

class GoalRepository implements RepositoryInterface
{
    // model property on class instances
    protected $model;

    // Constructor to bind model to repo
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    // Get all instances of model
    public function all(array $with = [])
    {
        return $this->model->with($with)->get();
    }

    // create a new record in the database
    public function create(array $data)
    {
        extract($data);
        $record = $this->model;
        $record->title = $title;
        $record->description = $description;
        $record->actual_target = $target;
        $record->current_target = $donations;
        $record->starting_date = $startDate;
        $record->ending_date = $endDate;
        $record->student_count = $student;
        $record->active = $status;
        $record->charity_id = $charity;
        $record->user_id = auth()->user()->id;
        $record->save();
        $file = $image;
        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $filePath = "goals/".$record->id.'/' . $fileName . time() . "." . $file->getClientOriginalExtension();
        $store = Storage::disk('user_profile')->put( $filePath, file_get_contents($file));
        $record->image = $filePath;
        $record->update();
        return $record;
        // $id = $this->model->id;
        // $userUpdate = $this->model->find($id);
        // Storage::disk('user_profile')->deleteDirectory('users/' .$id);
        // $file = $data['avatar'];
        // $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        // $filePath = "users/".$id.'/' . $fileName . time() . "." . $file->getClientOriginalExtension();
        // $store = Storage::disk('user_profile')->put( $filePath, file_get_contents($file));
        // $userUpdate->avatar = $filePath;
        // $userUpdate->update();
        // return $record;
    }

    // update record in the database
    public function update(array $data, Model $model)
    {
        extract($data);
        $model->title = $title;
        $model->description = $description;
        $model->actual_target = $target;
        $model->current_target = $donations;
        $model->starting_date = $startDate;
        $model->ending_date = $endDate;
        $model->active = $status;
        $model->student_count = $student;
        $model->charity_id = $charity;
        $model->user_id = auth()->user()->id;
        $model->save();
        if($imageRemove == 1) {
            $file = $image;
            Storage::disk('user_profile')->deleteDirectory('goals/' .$model->id);
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filePath = "goals/".$model->id.'/' . $fileName . time() . "." . $file->getClientOriginalExtension();
            Storage::disk('user_profile')->put( $filePath, file_get_contents($file));
            $model->image = $filePath;
            $model->update();
        }

        return $model;
    }

    // remove record from the database
    public function delete(Model $model)
    {
        Storage::disk('user_profile')->deleteDirectory('goals/' .$model->id);
        return $model->delete();
    }

    // show the record with the given id
    public function show($id,$relations= [])
    {
        return $this->model->with($relations)->findOrFail($id);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->model;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->model->with($relations);
    }

    // Sort the records by priority
    public function sort(array $order)
    {
        foreach($order as $priority => $id){
            $data = ['priority' => $priority + 1];
            $this->update($data, $id);
        }
    }

    // Get data for datatable
    public function getData($request, $with, $withCount, $whereChecks, $whereOps, $whereVals, $searchableCols, $orderableCols)
    {

        $start = $request->start ?? 0;
        $length = $request->length ?? 10;
        $filter = $request->search;
        $order = $request->order;
        $search = optional($filter)['value'] ?? false;
        $sort = optional($order)[0]['column'] ?? false;
        $dir = optional($order)[0]['dir'] ?? false;
        $from = $request->date_from;
        $to = $request->date_to;

        $records = $this->model->where('user_id',auth()->user()->id)->with($with)->withCount($withCount);

        if($whereChecks){
            foreach($whereChecks as $key => $check){
                $records->where($check, $whereOps[$key] ?? '=', $whereVals[$key]);
            }
        }

        $recordsTotal = $records->where('user_id',auth()->user()->id)->count();

        if($from){
            $records->where('user_id',auth()->user()->id)->whereDate('created_at' ,'>=', $from);
        }
        if($to){
            $records->where('user_id',auth()->user()->id)->whereDate('created_at' ,'<=', $to);
        }

        if($search){
            $records->where('user_id',auth()->user()->id)->where(function($query) use ($searchableCols, $search){
                foreach($searchableCols as $col){
                    $query->orWhere($col, 'like' , "%$search%");
                }
            });
        }
        $recordsFiltered = $records->where('user_id',auth()->user()->id)->count();

        if($dir){
            if(in_array($sort, $orderableCols)){
                $orderBy = $sort;
            }else{
                $orderBy = $orderableCols[$sort];
            }
            $records->orderBy($orderBy, $dir);
        }else{
            $records->latest();
        }
        $records = $records->limit($length)->offset($start)->get();

        $message = 'Success';
        $response = 200;

        return [
            'message' => $message,
            'response' => $response,
            'recordsFiltered' => $recordsFiltered,
            'recordsTotal' => $recordsTotal,
            'data' => $records,
        ];
    }
}
