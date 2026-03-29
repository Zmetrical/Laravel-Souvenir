@extends('admin.includes.layout')
@section('title', 'Add ' . ucfirst($preCategory ?? 'Element'))

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
  <a href="{{ route('admin.elements.' . ($preCategory ?? 'index')) }}" class="btn-ghost">
    <i data-lucide="arrow-left" style="width: 16px;"></i> Back
  </a>
  <div>
    <h5 class="mb-0" style="font-family: var(--fh); font-size: 2.2rem; color: var(--ink); letter-spacing: 1px;">Add New {{ ucfirst($preCategory ?? 'Element') }}</h5>
  </div>
</div>

@if($errors->any())
  <div style="background: #FEF2F2; border: 1.5px solid #FECACA; color: #DC2626; border-radius: 12px; padding: 16px; margin-bottom: 24px;">
    <div class="fw-bold mb-2">Check the following errors:</div>
    <ul class="mb-0 small fw-bold">@foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
  </div>
@endif

@include('admin.elements._form', [
  'action'      => route('admin.elements.store'),
  'method'      => 'POST',
  'preCategory' => $preCategory ?? null,
])

@endsection