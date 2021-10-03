<div class="page-inner">
    @if (!$form_active)
    <button class="btn btn-primary btn-sm" wire:click="{{$modal ? 'showModal' : 'toggleForm(true)'}}"><i
            class="fas fa-plus"></i> Add New </button>
    @endif
    @if ($form_active)
    <div>
        <x-text-field type="text" name="curriculumn_name" label="Curiculumn name" />

        <div class="form-group  pull-right">
            @if ($form_active)
            <button class="btn btn-danger btn-sm" wire:click="toggleForm(false)"><i class="fas fa-times"></i>
                Cancel</button>
            @endif
            <button class="btn btn-primary btn-sm" wire:click="{{$update_mode ? 'update' : 'store'}}">Simpan</button>
        </div>
    </div>
    @else
    <livewire:table.school-curiculumn-table params="{{$school_id}}" />
    @endif


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
                    <button class="btn btn-primary btn-sm" wire:click='_reset'><i class="fa fa-times pr-2"></i>Batal</a>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')


    <script>
        document.addEventListener('livewire:load', function(e) {
            window.livewire.on('loadForm', (data) => {
                
            });

            window.livewire.on('closeModal', (data) => {
                $('#confirm-modal').modal('hide')
            });
        })
    </script>
    @endpush
</div>