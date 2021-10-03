<?php

namespace App\Http\Livewire\Admin;

use App\Models\IntelligenceQuestion as ModelsIntelligenceQuestion;
use App\Models\SmartCategory;
use Livewire\Component;


class IntelligenceQuestion extends Component
{

    public $tbl_intelligence_questions_id;
    public $question_name;
    public $question_score;
    public $smart_category_id;



    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function mount($category_id)
    {
        $this->smart_category_id = $category_id;
    }

    public function render()
    {
        return view('livewire.admin.tbl-intelligence-questions', [
            'items' => ModelsIntelligenceQuestion::where('smart_category_id', $this->smart_category_id)->get(),
            'category' => SmartCategory::find($this->smart_category_id),
        ]);
    }

    public function store()
    {
        $this->_validate();

        $data = [
            'question_name'  => $this->question_name,
            'question_score'  => $this->question_score,
            'smart_category_id'  => $this->smart_category_id
        ];

        ModelsIntelligenceQuestion::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'question_name'  => $this->question_name,
            'question_score'  => $this->question_score,
            'smart_category_id'  => $this->smart_category_id
        ];
        $row = ModelsIntelligenceQuestion::find($this->tbl_intelligence_questions_id);



        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        ModelsIntelligenceQuestion::find($this->tbl_intelligence_questions_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'question_name'  => 'required',
            'question_score'  => 'required',
        ];

        return $this->validate($rule);
    }

    public function getDataById($tbl_intelligence_questions_id)
    {
        $tbl_intelligence_questions = ModelsIntelligenceQuestion::find($tbl_intelligence_questions_id);
        $this->tbl_intelligence_questions_id = $tbl_intelligence_questions->id;
        $this->question_name = $tbl_intelligence_questions->question_name;
        $this->question_score = $tbl_intelligence_questions->question_score;
        $this->smart_category_id = $tbl_intelligence_questions->smart_category_id;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($tbl_intelligence_questions_id)
    {
        $tbl_intelligence_questions = ModelsIntelligenceQuestion::find($tbl_intelligence_questions_id);
        $this->tbl_intelligence_questions_id = $tbl_intelligence_questions->id;
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
        $this->tbl_intelligence_questions_id = null;
        $this->question_name = null;
        $this->question_score = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
