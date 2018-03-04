@extends('layouts.app') 
@section('content')
<h2 class="page-title">Users</h2>
<section class="widget">
    <div class="body">
        <div class="mt">
            <table id="datatable-table" class="table table-striped table-hover">
                <thead>
                <tr>
                    <th class="no-sort width-50">#</th>
                    <th>Name</th>
                    <th class="no-sort">Email</th>
                    <th class="text-center">Role</th>
                    <th class="text-center width-200">Date</th>
                    <th class="no-sort"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr class="clickable-row" data-href="{{ route('users.edit', $user) }}">
                        <td>{{ $loop->index + 1 }}</td>
                        <td><span class="fw-semi-bold">{{ $user->name }}</span></td>
                        <td>{{ $user->email }}</td>
                        <td class="text-center">{{ $user->role->name }}</td>
                        <td class="text-center">{{ $user->created_at }}</td>
                        <td class="text-right">
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-primary btn-xs">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a data-href="{{ route('users.destroy', $user) }}" class="btn-delete btn btn-danger btn-xs">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<!-- page specific scripts -->
        <!-- page specific libs -->
        <script src="{{ asset('lib/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('lib/datatables/media/js/jquery.dataTables.min.js') }}"></script>

        <!-- page application js -->
        <script src="{{ asset('js/pages/user-index.js') }}"></script>
@endsection