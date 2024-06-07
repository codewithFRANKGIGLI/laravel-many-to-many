@extends('layouts.admin')

@section('content')
    @include('partials.flash-messages')
    <h2>{{ $project->name }}</h2>

    <div>
        <strong>ID</strong>: {{ $project->id }}
    </div>

    <div>
        <strong>Slug</strong>: {{ $project->slug }}
    </div>

    <div>
        <strong>Client name</strong>: {{ $project->client_name ? $project->client_name : 'empty' }}
    </div>

    <div>
        <strong>Type</strong>: {{ $project->type ? $project->type->name : 'no type' }}
    </div>
    <div>
        <strong>Technologies</strong>:
        {{-- if per le technologies --}}
        @if (count($project->technologies) > 0)
            @foreach ($project->technologies as $technology)
                {{ $technology->name }},
            @endforeach          
        @else
            No technologies
        @endif
    </div>
    <div>
        <strong>Created at</strong>: {{ $project->created_at }}
    </div>

    <div>
        <strong>Update at</strong>: {{ $project->updated_at }}
    </div>
    @if ($project->cover_img)
        <div>
            <img src="{{ asset('storage/' . $project->cover_img) }}" alt="{{ $project->name }}">
        </div>
    @endif
    <div class="mt-4">
        <strong>Summary</strong>

        <p>{{ $project->summary ? $project->summary : 'No summary' }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.projects.edit', ['project' => $project->slug]) }}" class="btn btn-success btn-sm">Edit</a>
        <form action="{{ route('admin.projects.destroy', ['project' => $project->slug]) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
        </form>
    </div>
@endsection
