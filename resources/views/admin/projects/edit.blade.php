@extends('layouts.admin')

@section('content')
    <h2>Edit the project: {{ $project->name }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('admin.projects.update', ['project' => $project->slug]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $project->name) }}">
        </div>
        <div class="mb-3">
            <label for="client_name" class="form-label">Client name</label>
            <input type="text" class="form-control" id="client_name" name="client_name" value="{{$project->client_name}}">
        </div>
        <div class="mb-3">
            <label for="type_id" class="form-label">Type</label>
            <select class="form-select" id="type_id" name="type_id">
                <option value="">Select a type</option>
                {{-- ciclo foreach per le varie option dei types --}}
                @foreach ($types as $type)
                    <option @selected($type->id == old('type_id', $project->type_id)) value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
              </select>
        </div>
        <div class="mb-3">
            <label for="cover_img" class="form-label">Image</label>
            <input class="form-control" type="file" id="cover_img" name="cover_img">
            
            @if ($project->cover_img)
                <div>
                    <img width="100" src="{{ asset('storage/' . $project->cover_img) }}" alt="{{ $project->name }}">
                </div>
            @else
                <small>No image</small>
            @endif
        </div>
        <div class="mb-3">
            <label for="summary" class="form-label">Summary</label>
            <input type="text" class="form-control" id="summary" name="summary" aria-describedby="emailHelp" value="{{$project->summary}}">
        </div>      
        <button type="submit" class="btn btn-primary">Save changes</button>
    </form>
@endsection