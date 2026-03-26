@extends('admin.layout')
@section('title', 'Edit Element')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
  <a href="{{ route('admin.elements.index') }}"
     class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">
    ← Back
  </a>
  <div>
    <h5 class="mb-0 fw-bold" style="color:#2D2D3A;">Edit: {{ $element->name }}</h5>
    <small class="text-muted font-monospace">slug: {{ $element->slug }}</small>
  </div>
</div>

@if($errors->any())
  <div class="flash-error mb-4">
    <strong>Please fix the following errors:</strong>
    <ul class="mb-0 mt-1">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

@include('admin.elements._form', [
  'action'     => route('admin.elements.update', $element),
  'method'     => 'PUT',
  'element'    => $element,
  'seriesList' => $seriesList,
])

@endsection