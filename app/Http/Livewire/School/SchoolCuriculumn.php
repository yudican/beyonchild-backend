<?php

namespace App\Http\Livewire\School;

use App\Models\SchoolCuriculumn as ModelsSchoolCuriculumn;
use Livewire\Component;


class SchoolCuriculumn extends Component
{

    public $tbl_school_curiculumns_id;
    public $curriculumn_name;



    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.school.tbl-school-curiculumns', [
            'items' => ModelsSchoolCuriculumn::all()
        ]);
    }

    public function store()
    {
        $this->_validate();
        $user = auth()->user();
        $data = ['curriculumn_name'  => $this->curriculumn_name];

        $user->school->curriculumns()->create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();
        $user = auth()->user();
        $data = ['curriculumn_name'  => $this->curriculumn_name];

        $user->school->curriculumns()->update($data);
        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        ModelsSchoolCuriculumn::find($this->tbl_school_curiculumns_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'curriculumn_name'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataById($tbl_school_curiculumns_id)
    {
        $tbl_school_curiculumns = ModelsSchoolCuriculumn::find($tbl_school_curiculumns_id);
        $this->tbl_school_curiculumns_id = $tbl_school_curiculumns->id;
        $this->curriculumn_name = $tbl_school_curiculumns->curriculumn_name;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($tbl_school_curiculumns_id)
    {
        $tbl_school_curiculumns = ModelsSchoolCuriculumn::find($tbl_school_curiculumns_id);
        $this->tbl_school_curiculumns_id = $tbl_school_curiculumns->id;
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
        $this->tbl_school_curiculumns_id = null;
        $this->curriculumn_name = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
