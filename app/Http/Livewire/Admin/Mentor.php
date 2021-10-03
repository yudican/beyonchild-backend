<?php

namespace App\Http\Livewire\Admin;

use App\Models\EducationLevel;
use App\Models\Mentor as ModelsMentor;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;


class Mentor extends Component
{

    public $tbl_mentors_id;
    public $mentor_name;
    public $mentor_title;
    public $mentor_link_meet;
    public $mentor_phone;
    public $mentor_email;
    public $mentor_experient;
    public $mentor_benefit;
    public $mentor_description;
    public $mentor_topic_description;
    public $user_id;
    public $education_level_id;



    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.admin.tbl-mentors', [
            'items' => ModelsMentor::all(),
            'levels' => EducationLevel::all()
        ]);
    }

    public function store()
    {
        $this->_validate();
        try {
            DB::beginTransaction();
            $role_mentor = Role::where('role_type', 'mentor')->first();
            $user = User::create([
                'name' => $this->mentor_name,
                'email' => $this->mentor_email,
                'password' => Hash::make('mentor123#'),
                'current_team_id' => 1,
            ]);
            $data = [
                'mentor_name'  => $this->mentor_name,
                'mentor_title'  => $this->mentor_title,
                'mentor_link_meet'  => $this->mentor_link_meet,
                'mentor_phone'  => $this->mentor_phone,
                'mentor_email'  => $this->mentor_email,
                'mentor_experient'  => $this->mentor_experient,
                'mentor_benefit'  => $this->mentor_benefit,
                'mentor_description'  => $this->mentor_description,
                'mentor_topic_description'  => $this->mentor_topic_description,
                'user_id'  => $user->id,
                'education_level_id'  => $this->education_level_id
            ];

            $user->roles()->attach($role_mentor->id);
            $user->teams()->attach(1, ['role' => $role_mentor->role_type]);
            ModelsMentor::create($data);
            DB::commit();
            $this->_reset();
            return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->emit('showAlertError', ['msg' => 'Data Gagal Disimpan ']);
        }
    }

    public function update()
    {
        $this->_validate();
        try {
            DB::beginTransaction();
            $data = [
                'mentor_name'  => $this->mentor_name,
                'mentor_title'  => $this->mentor_title,
                'mentor_link_meet'  => $this->mentor_link_meet,
                'mentor_phone'  => $this->mentor_phone,
                'mentor_email'  => $this->mentor_email,
                'mentor_experient'  => $this->mentor_experient,
                'mentor_benefit'  => $this->mentor_benefit,
                'mentor_description'  => $this->mentor_description,
                'mentor_topic_description'  => $this->mentor_topic_description,
                'education_level_id'  => $this->education_level_id
            ];
            $row = ModelsMentor::find($this->tbl_mentors_id);
            $row->user()->update([
                'name' => $this->mentor_name,
                'email' => $this->mentor_email,
            ]);
            $row->update($data);
            DB::commit();
            $this->_reset();
            return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->emit('showAlertError', ['msg' => 'Data Gagal Diupdate']);
        }
    }

    public function delete()
    {
        ModelsMentor::find($this->tbl_mentors_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'mentor_name'  => 'required',
            'mentor_title'  => 'required',
            'mentor_link_meet'  => 'required',
            'mentor_phone'  => 'required|numeric',
            'mentor_email'  => 'required|email',
            'mentor_experient'  => 'required|numeric',
            'mentor_benefit'  => 'required',
            'mentor_description'  => 'required',
            'mentor_topic_description'  => 'required',
            'education_level_id'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataById($tbl_mentors_id)
    {
        $tbl_mentors = ModelsMentor::find($tbl_mentors_id);
        $this->tbl_mentors_id = $tbl_mentors->id;
        $this->mentor_name = $tbl_mentors->mentor_name;
        $this->mentor_title = $tbl_mentors->mentor_title;
        $this->mentor_link_meet = $tbl_mentors->mentor_link_meet;
        $this->mentor_phone = $tbl_mentors->mentor_phone;
        $this->mentor_email = $tbl_mentors->mentor_email;
        $this->mentor_experient = $tbl_mentors->mentor_experient;
        $this->mentor_benefit = $tbl_mentors->mentor_benefit;
        $this->mentor_description = $tbl_mentors->mentor_description;
        $this->mentor_topic_description = $tbl_mentors->mentor_topic_description;
        $this->user_id = $tbl_mentors->user_id;
        $this->education_level_id = $tbl_mentors->education_level_id;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('loadForm');
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($tbl_mentors_id)
    {
        $tbl_mentors = ModelsMentor::find($tbl_mentors_id);
        $this->tbl_mentors_id = $tbl_mentors->id;
    }

    public function toggleForm($form)
    {
        $this->form_active = $form;
        $this->emit('loadForm');
    }

    public function showModal()
    {
        $this->emit('loadForm');
        $this->emit('showModal');
    }

    public function _reset()
    {
        $this->emit('closeModal');
        $this->emit('refreshTable');
        $this->tbl_mentors_id = null;
        $this->mentor_name = null;
        $this->mentor_title = null;
        $this->mentor_link_meet = null;
        $this->mentor_phone = null;
        $this->mentor_email = null;
        $this->mentor_experient = null;
        $this->mentor_benefit = null;
        $this->mentor_description = null;
        $this->mentor_topic_description = null;
        $this->user_id = null;
        $this->education_level_id = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
