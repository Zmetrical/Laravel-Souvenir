@extends('admin.includes.layout')
@section('title', 'Edit Element')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
  <a href="{{ route('admin.elements.' . $element->category) }}" class="btn-ghost">
    <i data-lucide="arrow-left" style="width: 16px;"></i> Back
  </a>
  <div>
    <h5 class="mb-0" style="font-family: var(--fh); font-size: 2.2rem; color: var(--ink); letter-spacing: 1px;">Edit: {{ $element->name }}</h5>
    <code style="font-size: 0.8rem; color: var(--grey-400); font-weight: 800;">SLUG: {{ $element->slug }}</code>
  </div>
</div>

@include('admin.elements._form', [
  'action'      => route('admin.elements.update', $element),
  'method'      => 'PUT',
  'element'     => $element,
  'preCategory' => $element->category,
])

@endsection