<?php

namespace WeThemes\WeBaltic\App\Http\Livewire\Dashboard\Tasks;

use App\Models\Task;
use App\Models\Upload;
use Livewire\Component;
use App\Traits\Livewire\DispatchSupport;

class LatestPrintingTasksBatch extends Component
{
    use DispatchSupport;

    public $upload;
    public $orders;
    public $tasks;

    public function mount()
    {
        $this->upload = Upload::whereHas('core_meta', function ($query) {
                $query->where('key', 'upload_tag')->where('value', 'printing-label');
            })
            ->orderBy('created_at', 'DESC')
            ->first();

        $tasks_ids = $this->upload->getWEF('batch_items');

        if(!empty($tasks_ids)) {
            $tasks_ids = array_map(function($task) {
                return $task['subject_id'];
            }, $tasks_ids);

            $this->tasks = Task::whereIn('id', $tasks_ids)->get();

            if(!empty($this->tasks)) {
                $this->orders = $this->tasks->reduce(function ($carry, $item) {
                    if(empty($carry)) $carry = collect();

                    return $carry->concat(collect($item->orders));
                });
            }
        }        
    }

    public function render()
    {
        return view('livewire.dashboard.tasks.latest-printing-tasks-batch');
    }
}