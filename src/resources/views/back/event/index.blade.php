@extends('layouts.template')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row gy-4">
        <!-- Congratulations card -->
        <div class="col-md-12 col-lg-12">
            @session('success')
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
            @endsession
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>เหตุการณ์</th>
                            <th>เหตุการณ์ที่พบ</th>
                            
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($event as $event)
                        <tr>
                            <td>{{ $event->event }}</td>
                            <td>{{ $event->event_note }}</td>
                            
                            <td>
                                @if($event->status == 1)
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('event.edit', $event->id) }}" class="btn btn-primary">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <a class="btn btn-primary" href="{{ route('event.create') }}">Add event</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('jsvendor')

@endsection