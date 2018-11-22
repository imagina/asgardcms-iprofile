@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('iprofile::profiles.title.profiles') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('iprofile::profiles.title.profiles') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">

            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>{{ trans('iprofile::profiles.title.fullname') }}</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>{{ trans('iprofile::profiles.title.completed') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($profiles)): ?>
                            <?php foreach ($profiles as $profile): ?>
                            <tr>
                                <td>{{$profile->user->id}}</td>
                                <td>{{$profile->user->present()->fullname}}</td>
                                <td>{{$profile->user->email}}</td>
                                <td>---</td>
                                <td>---</td>
                                <td>   
                                    <div class="btn-group">
                                        <a href="#" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>{{ trans('iprofile::profiles.title.fullname') }}</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>{{ trans('iprofile::profiles.title.completed') }}</th>
                                <th>{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </tfoot>
                        </table>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.box -->
            </div>

        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('iprofile::profiles.title.create profiles') }}</dd>
    </dl>
@stop

@push('js-stack')
   
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });
        });
    </script>
@endpush
