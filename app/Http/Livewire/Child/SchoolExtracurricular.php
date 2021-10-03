<?php

namespace App\Http\Livewire\Child;

use App\Models\SchoolExtracurricular as ModelsSchoolExtracurricular;
use Livewire\Component;


class SchoolExtracurricular extends Component
{

    public $tbl_school_extracurriculars_id;
    public $extracurricular_name;
    public $school_id;



    public $form_active = false;
    public $form = true;
    public $update_mode = false;
    public $modal = false;

    protected $listeners = ['getDataChildById', 'getChildId', 'showModalExtra'];

    public function mount($school_id = null)
    {
        $this->school_id = $school_id;
    }

    public function render()
    {
        return view('livewire.child.tbl-school-extracurriculars', [
            'items' => ModelsSchoolExtracurricular::all()
        ]);
    }

    public function store()
    {
        $this->_validate();

        $data = [
            'extracurricular_name'  => $this->extracurricular_name,
            'school_id'  => $this->school_id
        ];

        ModelsSchoolExtracurricular::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'extracurricular_name'  => $this->extracurricular_name,
            'school_id'  => $this->school_id
        ];
        $row = ModelsSchoolExtracurricular::find($this->tbl_school_extracurriculars_id);



        $row->update($data);

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
            'extracurricular_name'  => 'required',
        ];

        return $this->validate($rule);
    }

    public function getDataChildById($tbl_school_extracurriculars_id)
    {
        $tbl_school_extracurriculars = ModelsSchoolExtracurricular::find($tbl_school_extracurriculars_id);
        $this->tbl_school_extracurriculars_id = $tbl_school_extracurriculars->id;
        $this->extracurricular_name = $tbl_school_extracurriculars->extracurricular_name;
        $this->school_id = $tbl_school_extracurriculars->school_id;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getChildId($tbl_school_extracurriculars_id)
    {
        $tbl_school_extracurriculars = ModelsSchoolExtracurricular::find($tbl_school_extracurriculars_id);
        $this->tbl_school_extracurriculars_id = $tbl_school_extracurriculars->id;
    }

    public function showModalExtra($school_id)
    {
        $this->school_id = $school_id;
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
        $this->emit('refreshTable');
        $this->tbl_school_extracurriculars_id = null;
        $this->extracurricular_name = null;
        $this->form = true;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = false;
    }
}
