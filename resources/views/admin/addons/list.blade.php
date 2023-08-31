@extends('admin.master',['menu'=>'addons', 'sub_menu'=>'addons_list'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-12">
                <ul>
                    <li>{{__('Addons Lists')}}</li>
                    <li class="active-item">{{__('Addons')}}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
@php $update = false; @endphp
    <!-- User Management -->
 <div class="profile-info-form">
    <div class="row">
        <div class="col-md-6">
            <table class="table" id="module_list" >
                <thead>
                    <tr>
                        <th>Addons Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @if(isset($list))
                    @foreach($list as $item)
                        <tr>
                            <td>{{ $item['title'] }}</td>
                            <td>
                                <a href="{{ route('dashboardICO') }}" class="btn btn-primary">
                                {{ __('Manage') }}  
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
    <!-- /User Management -->
@endsection

@section('script')
    <script>
        $('#module_list').dataTable({
            dom: '',
            order : false
        });
    </script>
@endsection
