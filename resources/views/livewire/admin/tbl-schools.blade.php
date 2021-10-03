<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-capitalize">
                        <a href="{{route('dashboard')}}">
                            <span><i class="fas fa-arrow-left mr-3"></i>schools</span>
                        </a>
                        <div class="pull-right">
                            @if ($form_active)
                            <button class="btn btn-danger btn-sm" wire:click="toggleForm(false)"><i
                                    class="fas fa-times"></i> Cancel</button>
                            @else
                            <button class="btn btn-primary btn-sm"
                                wire:click="{{$modal ? 'showModal' : 'toggleForm(true)'}}"><i class="fas fa-plus"></i>
                                Add
                                New</button>
                            @endif
                        </div>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            @if ($form_active)
            <div class="card">
                <div class="card-body row">
                    <div class="col-md-6">
                        <x-text-field type="text" name="school_name" label="Name" />
                        <x-text-field type="text" name="school_address" label="Address" />
                        <x-text-field type="text" name="school_map_address" label="Map address url" />
                        <x-text-field type="text" name="school_phone_number" label="Phone number" />
                    </div>
                    <div class="col-md-6">
                        <x-text-field type="text" name="school_email" label="Email" />
                        <x-text-field type="number" name="school_fee_monthly" label="Biaya Bulanan" />
                        <x-select name="education_level_id" label="Level">
                            <option value="">Select Level</option>
                            @foreach ($levels as $level)
                            <option value="{{$level->id}}">{{$level->education_level_name}}</option>
                            @endforeach
                        </x-select>
                        <x-select name="school_location_id" label="Location">
                            <option value="">Select Location</option>
                            @foreach ($locations as $location)
                            <option value="{{$location->id}}">{{$location->school_location_name}}</option>
                            @endforeach
                        </x-select>
                    </div>
                    <div class="col-md-12">
                        <x-select name="facility_id" label="Facility" id="choices-multiple-remove-button" multiple
                            ignore>
                            @foreach ($facilities as $facility)
                            <option value="{{$facility->id}}">{{$facility->facility_name}}</option>
                            @endforeach
                        </x-select>
                    </div>
                    <div class="col-md-4">
                        <x-select name="school_accreditation" label="Akreditasi">
                            <option value="">Select Akreditasi</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </x-select>
                        <x-text-field type="number" name="school_teacher_count" label="Teacher" />
                    </div>
                    <div class="col-md-4">
                        <x-select name="school_day_start" label="Day Start">
                            <option value="">Select Day Start</option>
                            <option value="senin">Senin</option>
                            <option value="selasa">Selasa</option>
                            <option value="rabu">Rabu</option>
                            <option value="kamis">Kamis</option>
                            <option value="jum'at">Jum'at</option>
                            <option value="sabtu">Sabtu</option>
                            <option value="minggu">Minggu</option>
                        </x-select>
                        <x-select name="school_day_end" label="Day End">
                            <option value="">Select Day End</option>
                            <option value="senin">Senin</option>
                            <option value="selasa">Selasa</option>
                            <option value="rabu">Rabu</option>
                            <option value="kamis">Kamis</option>
                            <option value="jum'at">Jum'at</option>
                            <option value="sabtu">Sabtu</option>
                            <option value="minggu">Minggu</option>
                        </x-select>
                    </div>
                    <div class="col-md-4">
                        <x-text-field type="time" name="school_day_open" label="Day open" />
                        <x-text-field type="time" name="school_day_close" label="Day close" />
                    </div>
                    <div class="col-md-12">
                        <x-input-photo foto="{{$school_image}}" path="{{optional($school_image_path)->temporaryUrl()}}"
                            name="school_image_path" label="Logo" />
                        <div wire:ignore
                            class="form-group @error('school_description')has-error has-feedback @enderror">
                            <label for="school_description" class="text-capitalize">Description</label>
                            <textarea wire:model="school_description" id="school_description"
                                class="form-control"></textarea>
                            @error('school_description')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary pull-right"
                            wire:click="{{$update_mode ? 'update' : 'store'}}">Simpan</button>
                    </div>
                </div>
            </div>
            @else
            <livewire:table.school-table />
            @endif

        </div>

        {{-- Modal confirm --}}
        <div id="confirm-modal" wire:ignore.self class="modal fade" tabindex="-1" permission="dialog"
            aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog" permission="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="my-modal-title">Konfirmasi Hapus</h5>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin hapus data ini.?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" wire:click='delete' class="btn btn-danger btn-sm"><i
                                class="fa fa-check pr-2"></i>Ya, Hapus</button>
                        <button class="btn btn-primary btn-sm" wire:click='_reset'><i
                                class="fa fa-times pr-2"></i>Batal</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- curriculumn --}}
        <div id="curiculumn-modal" wire:ignore.self class="modal fade" tabindex="-1" permission="dialog"
            aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog modal-lg" permission="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="my-modal-title">Add Curriculumn</h5>
                    </div>
                    <div class="modal-body">
                        @if ($school_id)
                        @livewire('child.school-curiculumn', ['school_id' => $school_id])
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-sm" wire:click='_reset'><i
                                class="fa fa-times pr-2"></i>Close</a>
                    </div>
                </div>
            </div>
        </div>


        {{-- extracurriculer --}}
        <div id="extracurriculer-modal" wire:ignore.self class="modal fade" tabindex="-1" permission="dialog"
            aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog modal-lg" permission="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="my-modal-title">Add Extracurriculer</h5>
                    </div>
                    <div class="modal-body">
                        @if ($school_id)
                        @livewire('child.school-extracurricular', ['school_id' => $school_id])
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-sm" wire:click='_reset'><i
                                class="fa fa-times pr-2"></i>Close</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="{{asset('assets/js/plugin/summernote/summernote-bs4.min.js')}}"></script>
    <script src="{{ asset('assets/js/plugin/select2/select2.full.min.js') }}"></script>
    <script>
        document.addEventListener('livewire:load', function(e) {
            window.livewire.on('loadForm', (data) => {
                $('#school_description').summernote({
                    placeholder: 'school_description',
                    fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
                    tabsize: 2,
                    height: 300,
                    callbacks: {
                            onChange: function(contents, $editable) {
                                @this.set('school_description', contents);
                            }
                        }
                });

                $('#choices-multiple-remove-button').select2({
                    theme: "bootstrap",
                });
                
                $('#choices-multiple-remove-button').on('change', function (e) {
                    let data = $(this).val();
                    console.log(data)
                    @this.set('facility_id', data);
                });
            });

            window.livewire.on('closeModal', (data) => {
                $('#confirm-modal').modal('hide')
                $('#curiculumn-modal').modal('hide')
                $('#extracurriculer-modal').modal('hide')
            });

            window.livewire.on('showModalCuriculumn', (data) => {
                @this.set('school_id', data);
                setTimeout(() => {
                    $('#curiculumn-modal').modal('show')
                }, 1000);
                
            });

            window.livewire.on('showModalExtra', (data) => {
                @this.set('school_id', data);
                setTimeout(() => {
                    $('#extracurriculer-modal').modal('show')
                }, 1000);
                
            });
        })
    </script>
    @endpush
</div>