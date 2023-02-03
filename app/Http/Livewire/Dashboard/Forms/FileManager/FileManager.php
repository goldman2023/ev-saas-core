<?php

namespace App\Http\Livewire\Dashboard\Forms\FileManager;

use DB;
use EVS;
use Purifier;
use App\Models\Upload;
use Livewire\Component;
use App\Traits\Livewire\RulesSets;
use App\Traits\Livewire\DispatchSupport;
use Spatie\ValidationRules\Rules\ModelsExist;

class FileManager extends Component
{
    use RulesSets;
    use DispatchSupport;

    public $files;
    public $subject;
    public $field;
    public $errorField;
    public $fileType;
    public $template;
    public $multiple;
    public $addNewItemLabel;
    public $wrapperClass;
    public $whereWefs;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($subject = null, $field = '', $template = 'image', $fileType = 'image', $errorField = '', $multiple = false, $addNewItemLabel = 'Add', $wrapperClass = '', $whereWefs = [])
    {
        $this->subject = $subject;
        $this->field = $field;
        $this->errorField = $errorField;
        $this->template = $template;
        $this->multiple = $multiple;
        $this->fileType = $fileType;
        $this->addNewItemLabel = $addNewItemLabel;
        $this->wrapperClass = $wrapperClass;

        $this->whereWefs = $whereWefs;

        // Filter Uploads from $subject->{$field} by provided wefs
        $this->files = !empty($this->subject->{$field} ?? null) ? 
            $this->subject->getUploadsWhere(property_name: $this->field, return_all: true, wef_params: $this->whereWefs)->map(function($upload, $key) {
                return toJSONMedia($upload);
            })->filter()->values() : [];
    }

    protected function rules()
    {
        return [
            'subject.'.$this->field => [''],
        ];
    }

    protected function messages()
    {
        return [];
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('init-file-manager-form');
    }

    public function render()
    {
        return view('livewire.dashboard.forms.file-manager.file-manager');
    }

    public function saveFiles()
    {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate();
        }
        
        DB::beginTransaction();

        try {
            $this->subject->syncUploads(specific_property: $this->field);

            DB::commit();

            $this->inform('Files successfully added!', '', 'success');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while adding a file...Please try again.'));
            $this->inform('There was an error while adding a file...Please try again.', '', 'fail');
        }
    }

    public function removeFile()
    {
        DB::beginTransaction();

        try {
            $this->subject->syncUploads(specific_property: $this->field);

            DB::commit();

            $this->inform(translate('File successfully removed!'), '', 'success');
        } catch (\Exception $e) {
            $this->dispatchGeneralError(translate('There was an error while trying to remove file: ').$e->getMessage());
            $this->inform(translate('There was an error while trying to remove file: '), $e->getMessage(), 'danger');
        }
    }
}
