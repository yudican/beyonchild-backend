<?php

namespace App\Http\Livewire\School;

use App\Models\MentorSchedule as ModelsMentorSchedule;
use Livewire\Component;


class MentorSchedule extends Component
{

    public $tbl_mentor_schedules_id;
    public $schedule_title;
    public $schedule_date;
    public $schedule_time_start;
    public $schedule_time_end;
    public $mentor_id;



    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.school.tbl-mentor-schedules', [
            'items' => ModelsMentorSchedule::all()
        ]);
    }

    public function store()
    {
        $this->_validate();

        $data = [
            'schedule_title'  => $this->schedule_title,
            'schedule_date'  => $this->schedule_date,
            'schedule_time_start'  => $this->schedule_time_start,
            'schedule_time_end'  => $this->schedule_time_end,
            'mentor_id'  => auth()->user()->mentor->id
        ];

        ModelsMentorSchedule::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'schedule_title'  => $this->schedule_title,
            'schedule_date'  => $this->schedule_date,
            'schedule_time_start'  => $this->schedule_time_start,
            'schedule_time_end'  => $this->schedule_time_end,
        ];
        $row = ModelsMentorSchedule::find($this->tbl_mentor_schedules_id);



        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        ModelsMentorSchedule::find($this->tbl_mentor_schedules_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'schedule_title'  => 'required',
            'schedule_date'  => 'required',
            'schedule_time_start'  => 'required',
            'schedule_time_end'  => 'required',
        ];

        return $this->validate($rule);
    }

    public function getDataById($tbl_mentor_schedules_id)
    {
        $tbl_mentor_schedules = ModelsMentorSchedule::find($tbl_mentor_schedules_id);
        $this->tbl_mentor_schedules_id = $tbl_mentor_schedules->id;
        $this->schedule_title = $tbl_mentor_schedules->schedule_title;
        $this->schedule_date = $tbl_mentor_schedules->schedule_date;
        $this->schedule_time_start = $tbl_mentor_schedules->schedule_time_start;
        $this->schedule_time_end = $tbl_mentor_schedules->schedule_time_end;
        $this->mentor_id = $tbl_mentor_schedules->mentor_id;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($tbl_mentor_schedules_id)
    {
        $tbl_mentor_schedules = ModelsMentorSchedule::find($tbl_mentor_schedules_id);
        $this->tbl_mentor_schedules_id = $tbl_mentor_schedules->id;
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
        $this->tbl_mentor_schedules_id = null;
        $this->schedule_title = null;
        $this->schedule_date = null;
        $this->schedule_time_start = null;
        $this->schedule_time_end = null;
        $this->mentor_id = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
