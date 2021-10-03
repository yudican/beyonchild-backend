<?php

namespace App\Http\Livewire\Child;

use App\Models\SchoolCuriculumn as ModelsSchoolCuriculumn;
use Livewire\Component;


class SchoolCuriculumn extends Component
{

    public $tbl_school_curiculumns_id;
    public $curriculumn_name;
    public $school_id;



    public $form_active = false;
    public $form = true;
    public $update_mode = false;
    public $modal = false;

    protected $listeners = ['getDataChildById', 'getChildId', 'showModalCuriculumn'];

    public function mount($school_id = null)
    {
        $this->school_id = $school_id;
    }

    public function render()
    {
        return view('livewire.child.tbl-school-curiculumns', [
            'items' => ModelsSchoolCuriculumn::where('school_id', $this->school_id)->get()
        ]);
    }

    public function store()
    {
        $this->_validate();

        $data = [
            'curriculumn_name'  => $this->curriculumn_name,
            'school_id'  => $this->school_id
        ];

        ModelsSchoolCuriculumn::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'curriculumn_name'  => $this->curriculumn_name,
            'school_id'  => $this->school_id
        ];
        $row = ModelsSchoolCuriculumn::find($this->tbl_school_curiculumns_id);



        $row->update($data);

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
            'curriculumn_name'  => 'required',
        ];

        return $this->validate($rule);
    }

    public function getDataChildById($tbl_school_curiculumns_id)
    {
        $tbl_school_curiculumns = ModelsSchoolCuriculumn::find($tbl_school_curiculumns_id);
        $this->tbl_school_curiculumns_id = $tbl_school_curiculumns->id;
        $this->curriculumn_name = $tbl_school_curiculumns->curriculumn_name;
        $this->school_id = $tbl_school_curiculumns->school_id;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getChildId($tbl_school_curiculumns_id)
    {
        $tbl_school_curiculumns = ModelsSchoolCuriculumn::find($tbl_school_curiculumns_id);
        $this->tbl_school_curiculumns_id = $tbl_school_curiculumns->id;
    }

    public function showModalCuriculumn($school_id)
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
        // $this->emit('closeModal');
        $this->emit('refreshTable');
        $this->tbl_school_curiculumns_id = null;
        $this->curriculumn_name = null;
        $this->form = true;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = false;
    }
}
