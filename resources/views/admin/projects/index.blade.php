@extends('layouts.admin')
@section('content')
    @include('partials.flash-messages')

    <h2>Projects</h2>
    {{-- Tabella progetti --}}
    <table class="table table-striped table-bordered align-middle">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Client name</th>
                <th scope="col">Type</th>
                <th scope="col">Technologies</th>
                <th scope="col">Image</th>
                <th scope="col">Created at</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr class="">
                    <td>{{ $project->id }}</td>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->client_name }}</td>
                    {{-- td per types --}}
                    <td>{{ $project->type ? $project->type->name : 'no type' }}</td>
                    <td>
                        @foreach ($project->technologies as $technology)
                            {{ $technology->name }}{{ $loop->last ? '' : ', ' }}
                        @endforeach
                    </td>


                    {{-- mettere un if --}}
                    <td>
                        @if ($project->cover_img)
                            <div>
                                <img src="{{ asset('storage/' . $project->cover_img) }}" alt="{{ $project->name }}"
                                    style="width: 5rem">
                            </div>
                        @endif
                    </td>

                    <td>{{ $project->created_at }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.projects.show', ['project' => $project->slug]) }}"
                                class="btn btn-success btn-sm">View</a>
                            <a href="{{ route('admin.projects.edit', ['project' => $project->slug]) }}"
                                class="btn btn-success btn-sm">Edit</a>
                            <form action="{{ route('admin.projects.destroy', ['project' => $project->slug]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
