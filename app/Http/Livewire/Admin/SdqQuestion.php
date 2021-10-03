<?php

namespace App\Http\Livewire\Admin;

use App\Models\SdqQuestion as ModelsSdqQuestion;
use App\Models\SdqQuestionOption;
use Illuminate\Support\Facades\DB;
use Livewire\Component;


class SdqQuestion extends Component
{

    public $tbl_sdq_questions_id;
    public $question_name;
    public $question_description;

    // multiple input
    public $question_option;
    public $inputs = [0, 0, 0];
    public $i;


    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.admin.tbl-sdq-questions', [
            'items' => ModelsSdqQuestion::all()
        ]);
    }

    public function store()
    {
        $this->_validate();

        try {
            DB::beginTransaction();
            $data = [
                'question_name'  => $this->question_name,
                'question_description'  => $this->question_description
            ];

            $question = ModelsSdqQuestion::create($data);
            for ($i = 0; $i < count($this->inputs); $i++) {
                $question->sdqQuestionOption()->create([
                    'option_name'  => $this->question_option[$i],
                ]);
            }
            DB::commit();
            $this->_reset();
            return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->emit('showAlertError', ['msg' => 'Data Gagal Disimpan ' . $th->getMessage()]);
        }
    }

    public function update()
    {
        $this->_validate();

        try {
            DB::beginTransaction();
            $data = [
                'question_name'  => $this->question_name,
                'question_description'  => $this->question_description
            ];

            $row = ModelsSdqQuestion::find($this->tbl_sdq_questions_id);



            $row->update($data);

            for ($i = 0; $i < count($this->inputs); $i++) {
                $row->sdqQuestionOption()->update([
                    'question_option'  => $this->question_option[$i],
                    'sdq_question_id'  => $row->id,
                ]);
            }
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
        ModelsSdqQuestion::find($this->tbl_sdq_questions_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'question_name'  => 'required',
        ];

        return $this->validate($rule);
    }

    public function getDataById($tbl_sdq_questions_id)
    {
        $tbl_sdq_questions = ModelsSdqQuestion::find($tbl_sdq_questions_id);
        $this->tbl_sdq_questions_id = $tbl_sdq_questions->id;
        $this->question_name = $tbl_sdq_questions->question_name;
        $this->question_description = $tbl_sdq_questions->question_description;
        $this->inputs = $tbl_sdq_questions->sdqQuestionOption()->pluck('id')->toArray();
        $this->question_option = $tbl_sdq_questions->sdqQuestionOption()->pluck('option_name')->toArray();
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($tbl_sdq_questions_id)
    {
        $tbl_sdq_questions = ModelsSdqQuestion::find($tbl_sdq_questions_id);
        $this->tbl_sdq_questions_id = $tbl_sdq_questions->id;
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
        $this->tbl_sdq_questions_id = null;
        $this->question_name = null;
        $this->question_description = null;
        $this->question_option = null;
        $this->inputs = [0, 0, 0];
        $this->i;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs, $i);
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
    }
}
