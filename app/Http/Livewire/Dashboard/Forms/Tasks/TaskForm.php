<?php

namespace App\Http\Livewire\Dashboard\Forms\Tasks;

use App\Enums\TaskTypesEnum;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\CoreMeta;
use App\Models\Task;
use App\Builders\BaseBuilder;
use MyShop;
use App\Traits\Livewire\DispatchSupport;
use App\Traits\Livewire\RulesSets;
use Permissions;
use Purifier;
use DB;
use EVS;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Spatie\ValidationRules\Rules\ModelsExist;

class TaskForm extends Component
{
    use RulesSets;
    use DispatchSupport;

    public $task;

    public $is_update;
    public $shop_staff;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($task = null)
    {
        $this->task = empty($task) ? new Task() : $task;
        $this->is_update = isset($this->task->id) && ! empty($this->task->id);
        $this->shop_staff = MyShop::getShop()->users;

        if (!$this->is_update) {
            $this->task->status = TaskTypesEnum::issue()->value;
        }

    }


    protected function rules(){

        return [
            'task.name' => 'required',
            'task.subject_type' => 'required',
            'task.type' => 'required',
            'task.excerpt' => 'required',
            'task.content' => 'required',
            'task.status' => [Rule::in(TaskTypesEnum::toValues())],
            'task.assignee_id' => [Rule::in($this->shop_staff->name)],
        ];
    }

    protected function messages(){
    
        return [
            'task.name.required' => translate("The Task Name is required"),
            'task.subject_type.required' => translate("The Subject Type is required"),
            'task.type.required' => translate("The Task type is required"),
            'task.excerpt.required' => translate("The excerpt is required"),
            'task.content.required' => translate("The Content is required"),
            'task.status.in' => translate('Status must be one of the following:').' '.TaskTypesEnum::implodedLabels(),
            'task.assignee_id.in' => translate('Task assignee must be chosen from the list of shop staff'),
        ];
    }

    public function saveTask(){

        $msg = '';
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->task->status = TaskTypesEnum::issue()->value;
            $this->validate();
        }

        DB::beginTransaction();

        try {

            $this->task->user_id = Auth::id();
            $this->task->subject_id = $this->task->subject() || 1;


            $this->task->save();

            DB::commit();

            $this->inform(translate('Task saved'), $msg, 'success');
            if (!$this->is_update){
            return redirect()->route('task.edit',['id'=>$this->task->id]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($this->is_update) {
                $this->dispatchGeneralError(translate('There was an error while updating an task...Please try again.'));
                $this->inform(translate('There was an error while updating an task...Please try again.'), '', 'fail');
            } else {
                $this->dispatchGeneralError(translate('There was an error while creating an task...Please try again.'));
                $this->inform(translate('There was an error while creating an task...Please try again.'), '', 'fail');
            }
        }
    }

    public function removeTask(){

//       $task = app($this->Task::class)->find($this->task->id)->fill($this->task->toArray());
  //     $task->remove();
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('init-form');
    }

    public function render()
    {
        return view('livewire.dashboard.forms.tasks.task-form');
    }
}


