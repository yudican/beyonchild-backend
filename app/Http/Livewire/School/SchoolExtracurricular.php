<?php

namespace App\Http\Livewire\School;

use App\Models\SchoolExtracurricular as ModelsSchoolExtracurricular;
use Livewire\Component;


class SchoolExtracurricular extends Component
{

    public $tbl_school_extracurriculars_id;
    public $extracurricular_name;



    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.school.tbl-school-extracurriculars', [
            'items' => ModelsSchoolExtracurricular::all()
        ]);
    }

    public function store()
    {
        $this->_validate();
        $user = auth()->user();
        $data = ['extracurricular_name'  => $this->extracurricular_name];
        $user->school->extracuriculars()->create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $user = auth()->user();
        $data = ['extracurricular_name'  => $this->extracurricular_name];
        $user->school->extracuriculars()->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        ModelsSchoolExtracurricular::find($this->tbl_school_extracurriculars_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'extracurricular_name'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataById($tbl_school_extracurriculars_id)
    {
        $tbl_school_extracurriculars = ModelsSchoolExtracurricular::find($tbl_school_extracurriculars_id);
        $this->tbl_school_extracurriculars_id = $tbl_school_extracurriculars->id;
        $this->extracurricular_name = $tbl_school_extracurriculars->extracurricular_name;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($tbl_school_extracurriculars_id)
    {
        $tbl_school_extracurriculars = ModelsSchoolExtracurricular::find($tbl_school_extracurriculars_id);
        $this->tbl_school_extracurriculars_id = $tbl_school_extracurriculars->id;
    }

    public function toggleForm($form)
    {
        $this->form_active = $form;
        $this->emit('loadForm');
    }

    public function showModal()
    {
        $this->emit('showModal');
    }

    public function _reset()
    {
        $this->emit('closeModal');
        $this->emit('refreshTable');
        $this->tbl_school_extracurriculars_id = null;
        $this->extracurricular_name = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
