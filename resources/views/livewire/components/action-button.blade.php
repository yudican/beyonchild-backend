<div class="d-flex" wire:ignore id="btn-list-{{ $id }}">
  @if (auth()->user()->hasTeamPermission($curteam, $segment.':update') ||
  auth()->user()->hasTeamPermission($curteam, $segment.':delete'))
  @if (auth()->user()->hasTeamPermission($curteam, $segment.':update'))
  <button class="btn btn-success btn-sm mr-2" wire:click="getDataById('{{ $id }}')" id="btn-edit-{{ $id }}"><i
      class="fas fa-edit"></i></button>
  @endif
  @if (auth()->user()->hasTeamPermission($curteam, $segment.':delete'))
  @if (isset($confirm) == false)
  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-modal"
    wire:click="getId('{{ $id }}')" id="btn-delete-{{ $id }}"><i class="fas fa-trash"></i></button>
  @else
  <button type="button" class="btn btn-danger btn-sm" wire:click="getId('{{ $id }}')" id="btn-delete-{{ $id }}"><i
      class="fas fa-trash"></i></button>
  @endif

  @endif
  @endif

  @if (isset($extra) == 'smart-category')
  <a href="{{route('intellegence-question', ['category_id' => $id])}}">
    <button type="button" class="btn btn-primary btn-sm ml-2" id="btn-question-{{ $id }}"><i
        class="fas fa-clipboard-list"></i> Option</button>
  </a>
  @endif

</div>