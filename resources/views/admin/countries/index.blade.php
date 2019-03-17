@extends('admin.index')

@section('content')

<div class="box">
  <div class="box-header">
    <h3 class="box-title">{{ $title }}</h3>
  </div>

  <div class="box-body">

    {!! Form::open(['id' => 'form_data', 'url' => aurl('countries/destroy/all'), 'method' => 'delete' ]) !!}
    {!! $dataTable->table([
        'class' => 'dataTable table table-striped table-hover table-bordered'
      ], true) !!}

    {!! Form::close() !!}   
  </div>

</div>

<div id="multibleDelete" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ trans('admin.delete') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert  alert-danger">
          <div class="empty_record hidden" hi>
            <h3>{{trans('admin.please_check_some_records')}}</h3>
          </div>

          <div class="not_empty_record hidden">
            <h3>{{trans('admin.ask_delete_item')}} <span class="record_count"></span></h3>          
          </div>
        </div>  
      </div>  
      <div class="modal-footer">

          <div class="empty_record hidden" hi>
              <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('admin.close')}}</button>

          </div>

          <div class="not_empty_record hidden">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('admin.no')}}</button>
            <input type="submit" class="btn btn-danger del_all" data-dismiss="modal" name="del_all" value="{{trans('admin.yes')}}">
          </div>
          
      </div>
    </div>
  </div>
</div>



@push('js')
<script type="text/javascript">
  delete_all()
</script>
{!! $dataTable->scripts() !!}
@endpush





@endsection