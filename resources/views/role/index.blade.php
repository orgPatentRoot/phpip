@extends('layouts.app')

@section('content')
<legend class="text-light">
  Actor roles
  <a href="role/create" class="btn btn-primary float-right" data-toggle="modal" data-target="#ajaxModal" title="Role" data-resource="/role/">Create a new Role</a>
</legend>
<div class="row">
  <div class="col">
    <div class="card overflow-auto" style="max-height: 640px;">
      <table class="table table-striped table-hover table-sm">
        <thead>
          <tr id="filter" class="bg-primary text-light">
            <td><input class="filter-input form-control form-control-sm" data-source="/role" name="Code" placeholder="Code" value="{{ old('Code') }}"></td>
            <td><input class="filter-input form-control form-control-sm" data-source="/role" name="Name" placeholder="Name" value="{{ old('Name') }}"></td>
            <td colspan="2">Notes</th>
          </tr>
        </thead>
        <tbody id="tableList">
          @foreach ($roles as $role)
          <tr class="reveal-hidden" data-id="{{ $role->code }}">
            <td>
              <a href="/role/{{ $role->code }}" data-panel="ajaxPanel" title="Role info">
                {{ $role->code }}
              </a>
            </td>
            <td>{{ $role->name }}</td>
            <td>{{ $role->notes }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="col-5">
    <div class="card border-info">
      <div class="card-header bg-info text-light">
        Role information
      </div>
      <div class="card-body p-2" id="ajaxPanel">
        <div class="alert alert-info" role="alert">
          Click on role to view and edit details
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')

@include('tables.table-js')

@stop
