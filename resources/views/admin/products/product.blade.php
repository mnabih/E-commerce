@extends('admin.index')
@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
  });
</script>
@endpush



<div class="box">
  <div class="box-header">
    <h3 class="box-title">{{ $title }}</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    {!! Form::open(['url'=>aurl('products'), 'files'=>true]) !!}

          <a href="" class="btn btn-primary">{{trans('admin.save') }}<i class="fa fa-save"></i></a>
          <a href="" class="btn btn-success">{{trans('admin.save_countinue') }}<i class="fa fa-save"></i></a>
          <a href="" class="btn btn-info">{{trans('admin.copy') }}<i class="fa fa-copy"></i></a>
          <a href="" class="btn btn-danger">{{trans('admin.delete') }}<i class="fa fa-trash"></i></a>

          <br>
          <br>
          <br>
         

          <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#product_info">{{trans('admin.product_info')}}</a></li>
            <li><a data-toggle="tab" href="#department">{{trans('admin.department')}}</a></li>
            <li><a data-toggle="tab" href="#product_setting">{{trans('admin.product_setting')}}</a></li>
            <li><a data-toggle="tab" href="#product_media">{{trans('admin.product_media')}}</a></li>
            <li><a data-toggle="tab" href="#product_size_weight">{{trans('admin.product_size_weight')}}</a></li>
            <li><a data-toggle="tab" href="#product_other_data">{{trans('admin.product_other_data')}}</a></li>
          </ul>

          <div class="tab-content">
            @include('admin.products.tabs.product_info')
            @include('admin.products.tabs.department')
            @include('admin.products.tabs.product_setting')
            @include('admin.products.tabs.product_media')
            @include('admin.products.tabs.product_size_weight')
            @include('admin.products.tabs.product_other_data')
            
          </div>
  



    

    {!! Form::submit(trans('admin.add'),['class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}
  </div>
</div>
  <!-- /.box-body -->
</div>
<!-- /.box -->
@endsection
