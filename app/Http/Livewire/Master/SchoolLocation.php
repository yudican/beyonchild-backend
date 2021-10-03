<?php

namespace App\Http\Livewire\Master;

use App\Models\SchoolLocation as ModelsSchoolLocation;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class SchoolLocation extends Component
{
    use WithFileUploads;
    public $tbl_school_locations_id;
    public $school_location_name;
    public $school_location_image;
    public $school_location_image_path;


    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.master.tbl-school-locations', [
            'items' => ModelsSchoolLocation::all()
        ]);
    }

    public function store()
    {
        $this->_validate();
        $school_location_image = $this->school_location_image_path->store('upload', 'public');
        $data = [
            'school_location_name'  => $this->school_location_name,
            'school_location_image'  => $school_location_image,
        ];

        ModelsSchoolLocation::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'school_location_name'  => $this->school_location_name,
            'school_location_image'  => $this->school_location_image
        ];
        $row = ModelsSchoolLocation::find($this->tbl_school_locations_id);


        if ($this->school_location_image_path) {
            $school_location_image = $this->school_location_image_path->store('upload', 'public');
            $data = ['school_location_image' => $school_location_image];
            if (Storage::exists('public/' . $this->school_location_image)) {
                Storage::delete('public/' . $this->school_location_image);
            }
        }

        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        ModelsSchoolLocation::find($this->tbl_school_locations_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'school_location_name'  => 'required',
        ];

        $rule['school_location_image_path'] = 'image';
        if (!$this->update_mode) {
            $rule['school_location_image_path'] = 'required|image';
        }

        return $this->validate($rule);
    }

    public function getDataById($tbl_school_locations_id)
    {
        $tbl_school_locations = ModelsSchoolLocation::find($tbl_school_locations_id);
        $this->tbl_school_locations_id = $tbl_school_locations->id;
        $this->school_location_name = $tbl_school_locations->school_location_name;
        $this->school_location_image = $tbl_school_locations->school_location_image;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($tbl_school_locations_id)
    {
        $tbl_school_locations = ModelsSchoolLocation::find($tbl_school_locations_id);
        $this->tbl_school_locations_id = $tbl_school_locations->id;
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
        $this->tbl_school_locations_id = null;
        $this->school_location_name = null;
        $this->school_location_image = null;
        $this->school_location_image_path = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
