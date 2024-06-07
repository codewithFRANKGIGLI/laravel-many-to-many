@extends('layouts.admin')
@section('content')
    <h2>Create a new project</h2>
    {{-- errors --}}

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
        </div>
        <div class="mb-3">
            <label for="client_name" class="form-label">Client name</label>
            <input type="text" class="form-control" id="client_name" name="client_name" value="{{ old('client_name') }}">
        </div>
        {{-- input per la selezione del type --}}
        <div class="mb-3">
            <label for="type_id" class="form-label">Type</label>
            <select class="form-select" id="type_id" name="type_id">
                <option value="">Select a type</option>
                @foreach ($types as $type)
                    <option @selected($type->id == old('type_id')) value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
            {{-- checkbox per le technologies --}}
            <div class="py-2">
                <label for="technologies" class="form-label">Technologies: </label><br>
                @foreach ($technologies as $technology)
                    <input class="form-check-input" type="checkbox" id="tag-{{ $technology->id }}" name="technologies[]"
                        value="{{ $technology->id }}" @checked(in_array($technology->id, old('technologies', [])))>
                    {{-- label --}}
                    <label class="form-check-label" for="tag-{{ $technology->id }}">
                        {{ $technology->name }}
                    </label>
                    <br>
                @endforeach
            </div>
            <div class="py-2">
                {{-- input per il caricamento di un immagine --}}
                <div class="mb-3">
                    <label for="cover_img" class="form-label">Image</label>
                    <input type="file" class="form-control" id="cover_img" name="cover_img">
                </div>
                <div class="mb-3">
                    <label for="summary" class="form-label">Summary</label>
                    <input type="text" class="form-control" id="summary" name="summary" value="{{ old('summary') }}">
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
@endsection
