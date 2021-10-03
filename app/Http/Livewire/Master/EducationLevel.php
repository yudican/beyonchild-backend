<?php

namespace App\Http\Livewire\Master;

use App\Models\EducationLevel as ModelsEducationLevel;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class EducationLevel extends Component
{
    use WithFileUploads;
    public $tbl_education_levels_id;
    public $education_level_name;
    public $education_level_image;
    public $education_level_image_path;


    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.master.tbl-education-levels', [
            'items' => ModelsEducationLevel::all()
        ]);
    }

    public function store()
    {
        $this->_validate();
        $education_level_image = $this->education_level_image_path->store('upload', 'public');
        $data = [
            'education_level_name'  => $this->education_level_name,
            'education_level_image'  => $education_level_image,
        ];

        ModelsEducationLevel::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'education_level_name'  => $this->education_level_name,
            'education_level_image'  => $this->education_level_image
        ];
        $row = ModelsEducationLevel::find($this->tbl_education_levels_id);

        if ($this->education_level_image_path) {
            $education_level_image = $this->education_level_image_path->store('upload', 'public');
            $data = ['education_level_image' => $education_level_image];
            if (Storage::exists('public/' . $this->education_level_image)) {
                Storage::delete('public/' . $this->education_level_image);
            }
        }

        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        ModelsEducationLevel::find($this->tbl_education_levels_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'education_level_name'  => 'required',
        ];

        $rule['education_level_image_path'] = 'image';
        if (!$this->update_mode) {
            $rule['education_level_image_path'] = 'required|image';
        }

        return $this->validate($rule);
    }

    public function getDataById($tbl_education_levels_id)
    {
        $tbl_education_levels = ModelsEducationLevel::find($tbl_education_levels_id);
        $this->tbl_education_levels_id = $tbl_education_levels->id;
        $this->education_level_name = $tbl_education_levels->education_level_name;
        $this->education_level_image = $tbl_education_levels->education_level_image;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($tbl_education_levels_id)
    {
        $tbl_education_levels = ModelsEducationLevel::find($tbl_education_levels_id);
        $this->tbl_education_levels_id = $tbl_education_levels->id;
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
        $this->tbl_education_levels_id = null;
        $this->education_level_name = null;
        $this->education_level_image = null;
        $this->education_level_image_path = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
