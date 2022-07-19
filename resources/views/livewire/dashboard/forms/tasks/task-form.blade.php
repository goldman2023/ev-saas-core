@push('head_scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.11/themes/airbnb.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush
<div class="w-full" x-data="{
    status: @js($task->status ?? App\Enums\TaskTypesEnum::issue()->value),
    assignee_id: @js($task->assignee_id ?? Auth::id()),
}" @validation-errors.window="$scrollToErrors($event.detail.errors, 700);" x-cloak>
    <div class="w-full relative">
        <x-ev.loaders.spinner class="absolute-center z-10 hidden" wire:target="saveTask()"
            wire:loading.class.remove="hidden"></x-ev.loaders.spinner>

        <div class="w-full" wire:loading.class="opacity-30 pointer-events-none" wire:target="saveTask()">

            <div class="grid grid-cols-12 gap-8 mb-10">
                {{-- Left side --}}
                <div class="col-span-12 xl:col-span-8">
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Task Details') }}
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('Here you can edit all task basic
                                information') }}</p>
                        </div>

                        <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
                            <!-- Name -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">

                                <label for="task.name"
                                    class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Name') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <x-dashboard.form.input field="task.name" placeholder="Name of Task" />

                                </div>
                            </div>
                            <!-- END Task Name -->

                            <!-- Subject Type -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">

                                <label for="task.subject_type"
                                    class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Subject Type') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <x-dashboard.form.input field="task.subject_type" placeholder="Subject Type" />

                                </div>
                            </div>
                            <!-- END Subject Type -->

                            <!-- Type -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">

                                <label for="task.type"
                                    class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Type') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <x-dashboard.form.input field="task.type" placeholder="Type" />

                                </div>
                            </div>
                            <!-- END Type -->


                            <!-- Excerpt -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">

                                <label for="task.excerpt"
                                    class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Excerpt') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-dashboard.form.input field="task.excerpt" placeholder="Excerpt" />

                                </div>
                            </div>
                            <!-- END Excerpt -->

                            
                            <!-- Content -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">

                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Content') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <textarea type="text" class="form-standard h-[80px] @error('task.content') is-invalid @enderror"
                                        placeholder="{{ translate('Write a short content to describe the task') }}" wire:model.defer="task.content">
                                </textarea>

                                    <x-system.invalid-msg class="w-full" field="task.content">
                                    </x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Content -->

                        </div>
                    </div>
                </div>


                {{-- Right side --}}
                <div class="col-span-12 xl:col-span-4">


                    {{-- Actions --}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
                        <!-- Status -->
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5">
                            <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                <span class="mr-2">{{ translate('Status') }}</span>

                                @if ($task->status === App\Enums\TaskTypesEnum::issue()->value)
                                    <span class="badge-success">{{ ucfirst($task->status) }}</span>
                                @elseif($task->status === App\Enums\TaskTypesEnum::payment()->value)
                                    <span class="badge-info">{{ ucfirst($task->status) }}</span>
                                @elseif($task->status === App\Enums\TaskTypesEnum::improvement()->value)
                                    <span class="badge-danger">{{ ucfirst($task->status) }}</span>
                                @elseif($task->status === App\Enums\TaskTypesEnum::other()->value)
                                    <span class="badge-purple">{{ ucfirst($task->status) }}</span>
                                @elseif($task->status === App\Enums\TaskTypesEnum::request()->value)
                                    <span class="badge-blue">{{ ucfirst($task->status) }}</span>
                                @endif
                            </label>

                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <x-dashboard.form.select :items="\App\Enums\TaskTypesEnum::toArray()" selected="status" :nullable="false">
                                </x-dashboard.form.select>
                            </div>
                        </div>
                        <!-- END Status -->

                        <!-- Assignee -->
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5">
                            <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                <span class="mr-2">{{ translate('Assignee') }}</span>

                            </label>

                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                @dd($shop_staff->attributes)
                                <x-dashboard.form.select :items="$shop_staff" selected="assignee_id" :nullable="false">
                                </x-dashboard.form.select>
                            </div>
                        </div>
                        <!-- END Assignee -->
                        <!-- SaveTask Button -->
                        <div
                            class="w-full flex justify-between sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5">

                            <button type="button" class="btn btn-primary ml-auto btn-sm"
                                @click="
                                $wire.set('task.status', status, true);
                                $wire.set('task.assignee_id', assignee_id, true);
                                @do_action('view.task-form.wire_set')
                            "
                                wire:click="saveTask()">
                                {{ translate('Save') }}
                            </button>
                        </div>
                        <!-- END SaveTask Button -->
                    </div>

                </div>
            </div>
        </div>
    </div>