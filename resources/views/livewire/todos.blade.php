<?php

use function Livewire\Volt\{state, with, usesPagination};

state([
    'task',
]);

usesPagination();
//get from database
with([
    'todos' => fn() => auth()->user()->todos()->paginate(2),
]);

//create action
$addTask = function () {
    $validated = $this->validate([
        'task' => ['required', 'string', 'max:255']
    ]);
    auth()->user()->todos()->create([
        'task' => $this->task
    ]);
    $this->task = '';
};

$deleteTask = function ($todo_id) {
    auth()->user()->todos()->find($todo_id)->delete();
}

?>

<div>
    <form wire:submit.prevent="addTask">
        <x-input-label for="task" :value="__('Task')" />
        <x-text-input 
            wire:model="task"
            id="task" 
            class="block mt-1 w-full" 
            type="text"
            placeholder="Add task..."
            name="task" />
        <x-primary-button 
            class="mt-4">Add Task
        </x-primary-button>
    </form>


    <div class="w-full mt-5">
        <div class="font-bold">
                Your todos
        </div>
        
        <div class="w-full mt-2">
            @foreach ($todos as $todo)
            <div class="flex justify-between">
                <div class="mt-2">
                    {{ $todo->task }}
                </div>
                <a href="#" wire:click="deleteTask({{ $todo->id }})" class="mt-2 text-white rounded px-2 bg-slate-800">
                    x
                </a>
            </div>
            @endforeach
            <div class="mt-5">
                {{ $todos->links() }}
            </div>
        </div>
    </div>
</div>
