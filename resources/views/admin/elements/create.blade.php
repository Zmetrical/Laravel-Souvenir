@extends('admin.includes.layout')
@section('title', 'Add ' . ucfirst($preCategory))

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
  <a href="{{ route('admin.elements.' . $preCategory) }}"
     class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">
    ← Back to {{ ucfirst($preCategory) }}
  </a>
  <div>
    <h5 class="mb-0 fw-bold" style="color:#2D2D3A;">Add New {{ ucfirst($preCategory) }}</h5>
    <small class="text-muted">Fill in the details below</small>
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
  'action'      => route('admin.elements.store'),
  'method'      => 'POST',
  'preCategory' => $preCategory,
])

@endsection