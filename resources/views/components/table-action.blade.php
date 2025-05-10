<div class="flex space-x-2">

    <a href="{{ route($route, $id) }}" class="px-2 py-1 text-blue-500 rounded hover:text-blue-600">
        Edit
    </a>

    <button wire:click="deleteConfirm({{ $id }})" class="px-2 py-1 text-red-500 rounded hover:text-red-600">
        Delete
    </button>


</div>
