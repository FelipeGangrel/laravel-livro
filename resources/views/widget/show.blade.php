@extends('layouts.master') @section('title')

<title>{{ $widget->name }} Widget</title>

@endsection 

@section('content')

<ol class='breadcrumb'>
    <li><a href='/'>Home</a></li>
    <li><a href='/widget'>Widgets</a></li>
    <li><a href='/widget/{{ $widget->id }}'>{{ $widget->name }}</a></li>
</ol>

<h1>{{ $widget->name }}</h1>

<hr/>

<div class="panel panel-default">

    <!-- Table -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Date Created</th>
                @if ( !$widget->trashed() )
                <th>Edit</th>
                @endif
                <th>{{ $widget->trashed() ? 'Restore' : 'Delete' }} </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $widget->id }} </td>
                @if ( !$widget->trashed() )
                <td><a href="/widget/{{ $widget->id }}/edit">{{ $widget->name }}</a></td>
                @else
                <td>{{ $widget->name }}</td>
                @endif
                <td>{{ $widget->created_at }}</td>
                @if( !$widget->trashed() )
                <td><a href="/widget/{{ $widget->id }}/edit"><button type="button" class="btn btn-default">Edit</button></a></td>
                @endif
                <td>
                    <div class="form-group">
                        @if( $widget->trashed() )
                            <form class="form" role="form" method="POST" action="{{ url('/widget/restore/'. $widget->id ) }}">
                                {{ csrf_field() }}
                                <input class="btn btn-info" Onclick="return ConfirmRestore();" type="submit" value="Restore">
                            </form>
                        @else 
                            <form class="form" role="form" method="POST" action="{{ url('/widget/'. $widget->id) }}">
                                <input type="hidden" name="_method" value="delete"> {{ csrf_field() }}
                                <input class="btn btn-danger" Onclick="return ConfirmDelete();" type="submit" value="Delete">
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

@endsection 

@section('scripts')
<script>
    function ConfirmDelete() {
        var x = confirm("Are you sure you want to delete?");
        if (x) {
            return true;
        } else {
            return false;
        }
    }

    function ConfirmRestore(){
        var x = confirm("Are you sure you want to restore?");
        if (x) {
            return true;
        } else {
            return false;
        }
    }
</script>
@endsection