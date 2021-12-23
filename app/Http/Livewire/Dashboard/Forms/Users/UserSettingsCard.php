<?php

namespace App\Http\Livewire\Dashboard\Forms\Users;

use App\Models\PaymentMethod;
use App\Models\PaymentMethodUniversal;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\SerialNumber;
use App\Models\User;
use Permissions;
use DB;
use EVS;
use Categories;
use Illuminate\Validation\Rule;
use Purifier;
use Spatie\ValidationRules\Rules\ModelsExist;
use Livewire\Component;
use App\Traits\Livewire\RulesSets;

class UserSettingsCard extends Component
{
    use RulesSets;

    public $user;
    public $role;
    public $all_roles;
    public $permissions;
    public $class;
    public $show_permissions_panel;

    protected function rules()
    {
        $rules = [
            'user.id' => [],
            'user.user_type' => [Rule::in(User::$user_types)],
            'user.name' => ['required','min:3'],
            'user.email' => ['required', 'email:rfc,dns'],
            'permissions.*' => [],
            'all_roles.*' => [],
            'role' => ['required'], //  Rule::in(Permissions::getRoles()->keys()->toArray())
        ];

        return $rules;
    }

    protected function messages()
    {
        $messages = [
            'user.name.required' => translate('User name is required'),
            'user.name.min' => translate('User name must be at least :min characters'),
            'user.email.required' => translate('User email is required'),
            'user.email.email' => translate('User email must be a valid email address'),
            'user.user_type.in' => translate('Only available user types for now are: '.implode(', ', User::$user_types)),
            'role.in' => translate('Only available roles for now, are: '.Permissions::getRoles(only_role_names: true)->join(','))
        ];

        return $messages;
    }

    /**
     * Create a new component instance.
     *
     * @param mixed|null $user
     * @param string $class
     * @return void
     */
    public function mount(mixed &$user = null, $all_roles = null, string $class = '')
    {

        $this->user = $user;
        $this->class = $class;
        $this->role = $user->roles->first()->id ?? null;
        $this->all_roles = $all_roles;
        $this->show_permissions_panel = false;
        $this->permissions = Permissions::getUserPermissions($user)->toArray();
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('initUserSettingsForm');
    }

    public function bulkAction($action) {
        if($action === 'select_all' || $action === 'deselect_all') {
            foreach($this->permissions as $key => $permission) {
                $this->permissions[$key]['selected'] = $action === 'select_all';
            }
        }
    }

    public function selectSpecificPermissions($items = []) {
        foreach($this->permissions as $key => $value) {
            if(in_array($key, $items)) {
                $this->permissions[$key]['selected'] = true;
            } else {
                $this->permissions[$key]['selected'] = false;
            }
        }
    }

    public function save() {
        $this->validate();

        // Save user data
        $this->user->save();

        $selected_permissions = collect($this->permissions)->where('selected', true)->keys();

        // Sync permissions
        $this->user->syncPermissions($selected_permissions->toArray());

        // Sync roles
        $this->user->syncRoles([$this->role]);

        $this->dispatchBrowserEvent('toast', ['id' => 'user-updated-toast', 'content' => $this->user->name.' ('.$this->user->email.') '.translate('updated successfully!'), 'type' => 'success' ]);
    }

    public function render()
    {
        return view('livewire.dashboard.forms.users.user-settings-card');
    }

}
