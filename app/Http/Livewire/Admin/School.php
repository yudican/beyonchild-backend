<?php

namespace App\Http\Livewire\Admin;

use App\Models\EducationLevel;
use App\Models\Facility;
use App\Models\School as ModelsSchool;
use App\Models\SchoolLocation;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class School extends Component
{
    use WithFileUploads;
    public $school_id = null;
    public $school_name;
    public $school_image;
    public $school_description;
    public $school_teacher_count;
    public $school_address;
    public $school_map_address;
    public $school_phone_number;
    public $school_email;
    public $school_fee_monthly;
    public $school_accreditation;
    public $school_day_start;
    public $school_day_end;
    public $school_day_open;
    public $school_day_close;
    public $school_location_id;
    public $education_level_id;
    public $facility_id = [];
    public $school_image_path;


    public $form_active = false;
    public $form = true;
    public $update_mode = false;
    public $modal = false;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.admin.tbl-schools', [
            'items' => ModelsSchool::all(),
            'locations' => SchoolLocation::all(),
            'levels' => EducationLevel::all(),
            'facilities' => Facility::all()
        ]);
    }

    public function store()
    {
        $this->_validate();
        $school_image = $this->school_image_path->store('upload', 'public');
        $data = [
            'school_name'  => $this->school_name,
            'school_image'  => $school_image,
            'school_description'  => $this->school_description,
            'school_teacher_count'  => $this->school_teacher_count,
            'school_address'  => $this->school_address,
            'school_map_address'  => $this->school_map_address,
            'school_phone_number'  => $this->school_phone_number,
            'school_email'  => $this->school_email,
            'school_fee_monthly'  => $this->school_fee_monthly,
            'school_accreditation'  => $this->school_accreditation,
            'school_day_start'  => $this->school_day_start,
            'school_day_end'  => $this->school_day_end,
            'school_day_open'  => $this->school_day_open,
            'school_day_close'  => $this->school_day_close,
            'school_location_id'  => $this->school_location_id,
            'education_level_id'  => $this->education_level_id
        ];

        $school = ModelsSchool::create($data);
        $school->facilities()->attach($this->facility_id);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'school_name'  => $this->school_name,
            'school_image'  => $this->school_image,
            'school_description'  => $this->school_description,
            'school_teacher_count'  => $this->school_teacher_count,
            'school_address'  => $this->school_address,
            'school_map_address'  => $this->school_map_address,
            'school_phone_number'  => $this->school_phone_number,
            'school_email'  => $this->school_email,
            'school_fee_monthly'  => $this->school_fee_monthly,
            'school_accreditation'  => $this->school_accreditation,
            'school_day_start'  => $this->school_day_start,
            'school_day_end'  => $this->school_day_end,
            'school_day_open'  => $this->school_day_open,
            'school_day_close'  => $this->school_day_close,
            'school_location_id'  => $this->school_location_id,
            'education_level_id'  => $this->education_level_id
        ];
        $row = ModelsSchool::find($this->school_id);

        if ($this->school_image_path) {
            $school_image = $this->school_image_path->store('upload', 'public');
            $data = ['school_image' => $school_image];
            if (Storage::exists('public/' . $this->school_image)) {
                Storage::delete('public/' . $this->school_image);
            }
        }

        $row->update($data);
        $row->facilities()->sync($this->facility_id);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        ModelsSchool::find($this->school_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'school_name'  => 'required',
            'school_description'  => 'required',
            'school_teacher_count'  => 'required|numeric',
            'school_address'  => 'required',
            'school_phone_number'  => 'required|numeric',
            'school_email'  => 'required',
            'school_fee_monthly'  => 'required|numeric',
            'school_accreditation'  => 'required',
            'school_day_start'  => 'required',
            'school_day_end'  => 'required',
            'school_day_open'  => 'required',
            'school_day_close'  => 'required',
            'school_location_id'  => 'required',
            'education_level_id'  => 'required'
        ];

        if (!$this->update_mode) {
            $rule['school_image_path'] = 'required|image';
        }

        return $this->validate($rule);
    }

    public function getDataById($school_id)
    {
        $tbl_schools = ModelsSchool::find($school_id);
        $this->school_id = $tbl_schools->id;
        $this->school_name = $tbl_schools->school_name;
        $this->school_image = $tbl_schools->school_image;
        $this->school_description = $tbl_schools->school_description;
        $this->school_teacher_count = $tbl_schools->school_teacher_count;
        $this->school_address = $tbl_schools->school_address;
        $this->school_map_address = $tbl_schools->school_map_address;
        $this->school_phone_number = $tbl_schools->school_phone_number;
        $this->school_email = $tbl_schools->school_email;
        $this->school_fee_monthly = $tbl_schools->school_fee_monthly;
        $this->school_accreditation = $tbl_schools->school_accreditation;
        $this->school_day_start = $tbl_schools->school_day_start;
        $this->school_day_end = $tbl_schools->school_day_end;
        $this->school_day_open = $tbl_schools->school_day_open;
        $this->school_day_close = $tbl_schools->school_day_close;
        $this->school_location_id = $tbl_schools->school_location_id;
        $this->education_level_id = $tbl_schools->education_level_id;

        $this->facility_id = $tbl_schools->facilities()->pluck('facilities.id')->toArray();
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($school_id)
    {
        $tbl_schools = ModelsSchool::find($school_id);
        $this->school_id = $tbl_schools->id;
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
        $this->school_id = null;
        $this->school_name = null;
        $this->school_image = null;
        $this->school_image_path = null;
        $this->school_description = null;
        $this->school_teacher_count = null;
        $this->school_address = null;
        $this->school_map_address = null;
        $this->school_phone_number = null;
        $this->school_email = null;
        $this->school_fee_monthly = null;
        $this->school_accreditation = null;
        $this->school_day_start = null;
        $this->school_day_end = null;
        $this->school_day_open = null;
        $this->school_day_close = null;
        $this->school_location_id = null;
        $this->education_level_id = null;
        $this->facility_id = [];
        $this->form = true;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = false;
    }
}
